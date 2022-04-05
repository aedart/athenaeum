<?php

namespace Aedart\MimeTypes;

use Aedart\Contracts\MimeTypes\Detector as DetectorInterface;
use Aedart\Contracts\MimeTypes\MimeType as MimeTypeInterface;
use Aedart\Contracts\MimeTypes\Sampler;
use Aedart\MimeTypes\Drivers\FileInfoSampler;
use Aedart\MimeTypes\Exceptions\FileNotFound;
use Aedart\MimeTypes\Exceptions\MimeTypeDetectionException;
use Aedart\MimeTypes\Exceptions\ProfileNotFound;

/**
 * Mime-Type Detector
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\MimeTypes
 */
class Detector implements DetectorInterface
{
    /**
     * Fallback profiles, when none given
     *
     * @var array
     */
    protected array $fallbackProfiles = [
        'default' => [
            'driver' => FileInfoSampler::class,
            'options' => [
                'sample_size' => 512,
                'magic_database' => null,
            ]
        ]
    ];

    /**
     * Creates a new mime-type detector instance
     *
     * @param  array  $profiles  [optional] List of available detection profiles
     * @param  string  $defaultProfile  [optional] Name of the default profile to use
     */
    public function __construct(
        protected array $profiles = [],
        protected string $defaultProfile = 'default'
    )
    {
        // Set fallback profiles, when none available
        if (empty($this->profiles)) {
            $this->usingProfiles($this->fallbackProfiles);
        }
    }

    /**
     * @inheritDoc
     */
    public function detect($data, ?string $profile = null, array $options = []): MimeTypeInterface
    {
        $sampler = $this->makeSampler($data, $profile, $options);

        return new MimeType(
            description: $sampler->getMimeTypeDescription(),
            type: $sampler->detectMimetype(),
            encoding: $sampler->detectEncoding(),
            mime: $sampler->detectMime(),
            extensions: $sampler->detectFileExtensions()
        );
    }

    /**
     * @inheritDoc
     */
    public function detectForFile(string $file, ?string $profile = null, array $options = []): MimeTypeInterface
    {
        if (!is_file($file)) {
            throw new FileNotFound(sprintf('File %s does not exist.', $file));
        }

        $stream = fopen($file, 'rb');
        if ($stream === false) {
            throw new MimeTypeDetectionException(sprintf('Unable to open file %s', $file));
        }

        $mimeType = $this->detect($stream, $profile, $options);
        fclose($stream);

        return $mimeType;
    }

    /**
     * @inheritDoc
     */
    public function makeSampler($data, ?string $profile = null, array $options = []): Sampler
    {
        $profile = $profile ?? $this->defaultProfile;

        // Abort if profile does not exist
        if (!isset($this->profiles[$profile])) {
            throw new ProfileNotFound(sprintf('Mime-Type detection profile %s does not exist', $profile));
        }

        // Resolve driver class and options
        $driver = $this->profiles[$profile]['driver'];
        $options = array_merge($this->profiles[$profile]['options'], $options);

        // Build and return sampler instance
        return new $driver($data, $options);
    }

    /**
     * Set the available mime-type detection profiles
     *
     * @param  array  $profiles
     *
     * @return self
     */
    public function usingProfiles(array $profiles): static
    {
        $this->profiles = $profiles;

        return $this;
    }

    /**
     * Set the name of the default mime-type detection profile to use
     *
     * @param  string  $name
     *
     * @return self
     */
    public function defaultProfile(string $name): static
    {
        $this->defaultProfile = $name;

        return $this;
    }
}
