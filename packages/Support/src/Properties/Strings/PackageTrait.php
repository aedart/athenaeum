<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Package Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\PackageAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait PackageTrait
{
    /**
     * Name of package. Can evt. contain path to package as well
     *
     * @var string|null
     */
    protected string|null $package = null;

    /**
     * Set package
     *
     * @param string|null $name Name of package. Can evt. contain path to package as well
     *
     * @return self
     */
    public function setPackage(string|null $name): static
    {
        $this->package = $name;

        return $this;
    }

    /**
     * Get package
     *
     * If no package value set, method
     * sets and returns a default package.
     *
     * @see getDefaultPackage()
     *
     * @return string|null package or null if no package has been set
     */
    public function getPackage(): string|null
    {
        if (!$this->hasPackage()) {
            $this->setPackage($this->getDefaultPackage());
        }
        return $this->package;
    }

    /**
     * Check if package has been set
     *
     * @return bool True if package has been set, false if not
     */
    public function hasPackage(): bool
    {
        return isset($this->package);
    }

    /**
     * Get a default package value, if any is available
     *
     * @return string|null Default package value or null if no default value is available
     */
    public function getDefaultPackage(): string|null
    {
        return null;
    }
}
