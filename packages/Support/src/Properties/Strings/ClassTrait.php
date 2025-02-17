<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Class Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\ClassAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait ClassTrait
{
    /**
     * The class of something or perhaps a class path
     *
     * @var string|null
     */
    protected string|null $class = null;

    /**
     * Set class
     *
     * @param string|null $class The class of something or perhaps a class path
     *
     * @return self
     */
    public function setClass(string|null $class): static
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Get class
     *
     * If no class value set, method
     * sets and returns a default class.
     *
     * @see getDefaultClass()
     *
     * @return string|null class or null if no class has been set
     */
    public function getClass(): string|null
    {
        if (!$this->hasClass()) {
            $this->setClass($this->getDefaultClass());
        }
        return $this->class;
    }

    /**
     * Check if class has been set
     *
     * @return bool True if class has been set, false if not
     */
    public function hasClass(): bool
    {
        return isset($this->class);
    }

    /**
     * Get a default class value, if any is available
     *
     * @return string|null Default class value or null if no default value is available
     */
    public function getDefaultClass(): string|null
    {
        return null;
    }
}
