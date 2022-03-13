<?php

namespace Aedart\Contracts\MimeTypes;

/**
 * Detectable
 *
 * File Component is able to detect its mime-type.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\MimeTypes
 */
interface Detectable
{
    /**
     * Returns the mime-type of this file
     *
     * @return MimeType
     */
    public function mimeType(): MimeType;
}
