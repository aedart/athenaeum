<?php

namespace Aedart\Contracts\Core\Helpers;

use RuntimeException;

/**
 * Application Namespace Detector
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Core\Helpers
 */
interface NamespaceDetector
{
    /**
     * Detect the application's namespace
     *
     * @param string $composerPath Full path to composer.json file
     *
     * @return string
     *
     * @throws RuntimeException
     */
    public function detect(string $composerPath): string;
}
