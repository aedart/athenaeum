<?php

namespace Aedart\MimeTypes;

use Aedart\Contracts\MimeTypes\Detector as DetectorInterface;
use Aedart\Contracts\MimeTypes\MimeType as MimeTypeInterface;
use Aedart\Contracts\MimeTypes\Sampler;
use Aedart\MimeTypes\Drivers\FileInfoSampler;
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
        return $this->makeMimeType(
            $this->makeSampler($data, $profile, $options)
        );
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
     * Returns a new mime-type object
     *
     * @param  Sampler  $sampler
     *
     * @return MimeTypeInterface
     */
    public function makeMimeType(Sampler $sampler): MimeTypeInterface
    {
        return new MimeType($sampler);
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
