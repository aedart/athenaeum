<?php

namespace Aedart\Utils\Packages;

use Aedart\Contracts\Utils\Packages\Version;

/**
 * Package Version
 *
 * @see \Aedart\Contracts\Utils\Packages\Version
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Utils\Packages
 */
class PackageVersion implements Version
{
    /**
     * Creates a new package version instance
     *
     * @param  string  $name Name of package
     * @param  string  $version Pretty or short version of installed package
     * @param  string|null  $fullVersion  [optional] Full version of installed package
     * @param  string|null  $reference  [optional] Reference hash of installed package version
     */
    public function __construct(
        protected string $name,
        protected string $version,
        protected string|null $fullVersion = null,
        protected string|null $reference = null
    ) {}

    /**
     * @inheritDoc
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function version(): string
    {
        return $this->version;
    }

    /**
     * @inheritDoc
     */
    public function fullVersion(): string|null
    {
        return $this->fullVersion;
    }

    /**
     * @inheritDoc
     */
    public function hasFullVersion(): bool
    {
        return isset($this->fullVersion);
    }

    /**
     * @inheritDoc
     */
    public function reference(): string|null
    {
        return $this->reference;
    }

    /**
     * @inheritDoc
     */
    public function hasReference(): bool
    {
        return isset($this->reference);
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->version();
    }
}
