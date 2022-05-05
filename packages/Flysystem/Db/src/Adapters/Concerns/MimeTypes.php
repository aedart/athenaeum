<?php

namespace Aedart\Flysystem\Db\Adapters\Concerns;

use Aedart\Contracts\MimeTypes\Detectable;
use Aedart\Contracts\MimeTypes\Exceptions\MimeTypeDetectionException;
use Aedart\Contracts\Streams\FileStream;
use League\Flysystem\Config;

/**
 * Concerns Mime Types
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Flysystem\Db\Adapters\Concerns
 */
trait MimeTypes
{
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

        // Otherwise, use the detectable stream's MIME-Type detector
        $profile = $config->get('mime_type_detector', null);
        $options = $config->get('mime_type_options', []);

        $mimeType = $stream->mimeType($profile, $options);
        if (!$mimeType->isValid()) {
            return null;
        }

        return $mimeType->type();
    }
}