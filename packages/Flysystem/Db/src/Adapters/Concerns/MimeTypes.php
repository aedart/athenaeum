<?php

namespace Aedart\Flysystem\Db\Adapters\Concerns;

use Aedart\Contracts\MimeTypes\Detectable;
use Aedart\Contracts\MimeTypes\Exceptions\MimeTypeDetectionException;
use Aedart\Contracts\Streams\FileStream;
use League\Flysystem\Config;

/**
 * Concerns Mime Types
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Flysystem\Db\Adapters\Concerns
 */
trait MimeTypes
{
    /**
     * MIME-Type detector callback
     *
     * @var callable|null
     */
    protected $detectorCallback = null;

    /**
     * Set a custom MIME-Type detector callback
     *
     * @param callable $callback Callback is given a {@see Detectable}|{@see FileStream} stream and
     *                           {@see Config} as arguments. String MIME-Type or `null` must be
     *                           returned by callback!
     *
     * @return self
     */
    public function detectMimeTypeUsing(callable $callback): static
    {
        $this->detectorCallback = $callback;

        return $this;
    }

    /**
     * Returns a default MIME-Type detector callback
     *
     * @return callable
     */
    public function defaultMimeTypeDetectorCallback(): callable
    {
        return function (Detectable|FileStream $stream, Config $config) {
            $profile = $config->get('mime_type_detector', null);
            $options = $config->get('mime_type_options', []);

            $mimeType = $stream->mimeType($profile, $options);
            if (!$mimeType->isValid()) {
                return null;
            }

            return $mimeType->type();
        };
    }

    /**
     * Resolve MIME-Type for given detectable file stream
     *
     * "mime_type" value from `$config` is returned, if provided.
     * Otherwise, a MIME-Type will be detected.
     *
     * @param Detectable $stream
     * @param Config|null $config [optional]
     *
     * @return string|null
     *
     * @throws MimeTypeDetectionException
     */
    protected function resolveMimeType(Detectable $stream, Config|null $config = null): string|null
    {
        $config = $config ?? new Config([]);

        // User provided MIME-Type if given via config.
        $providedMimeType = $config->get('mime_type');
        if (isset($providedMimeType)) {
            return $providedMimeType;
        }

        // Resolve detector callback and invoke it
        $detectorCallback = $this->detectorCallback ?? $this->defaultMimeTypeDetectorCallback();

        return $detectorCallback($stream, $config);
    }
}
