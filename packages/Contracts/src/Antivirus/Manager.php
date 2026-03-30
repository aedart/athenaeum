<?php

namespace Aedart\Contracts\Antivirus;

use Aedart\Contracts\Antivirus\Exceptions\ProfileNotFoundException;

/**
 * Antivirus Scanner Manager
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Antivirus
 */
interface Manager
{
    /**
     * Creates a new antivirus scanner instance or returns existing
     *
     * @param string|null $name [optional] Name of scanner profile to obtain or create
     * @param array $options [optional] Scanner options
     *
     * @return Scanner
     *
     * @throws ProfileNotFoundException
     */
    public function profile(string|null $name = null, array $options = []): Scanner;

    /**
     * Creates a new antivirus scanner instance
     *
     * @param class-string<Scanner>|null $driver [optional] Class path to {@see Scanner}
     * @param array $options [optional] Scanner options
     *
     * @return Scanner
     */
    public function scanner(string|null $driver = null, array $options = []): Scanner;

    /**
     * Returns class path of a default scanner to use
     *
     * @return class-string<Scanner>
     */
    public function defaultScanner(): string;
}
