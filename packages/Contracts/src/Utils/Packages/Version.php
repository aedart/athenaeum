<?php

namespace Aedart\Contracts\Utils\Packages;

use Stringable;

/**
 * Package Version
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Utils\Packages
 */
interface Version extends Stringable
{
    /**
     * Returns the package name
     *
     * @return string
     */
    public function name(): string;
    
    /**
     * Returns the "pretty" or short version
     *
     * @return string
     */
    public function version(): string;

    /**
     * Returns the full version, if available
     *
     * @return string|null
     */
    public function fullVersion(): string|null;

    /**
     * Determine if a full version is available
     *
     * @return bool
     */
    public function hasFullVersion(): bool;

    /**
     * Returns reference hash, if available
     *
     * @return string|null
     */
    public function reference(): string|null;

    /**
     * Determine if a reference hash is available
     *
     * @return bool
     */
    public function hasReference(): bool;
}
