<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Namespace Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\NamespaceAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait NamespaceTrait
{
    /**
     * Namespace
     *
     * @var string|null
     */
    protected string|null $namespace = null;

    /**
     * Set namespace
     *
     * @param string|null $namespace Namespace
     *
     * @return self
     */
    public function setNamespace(string|null $namespace): static
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * Get namespace
     *
     * If no namespace value set, method
     * sets and returns a default namespace.
     *
     * @see getDefaultNamespace()
     *
     * @return string|null namespace or null if no namespace has been set
     */
    public function getNamespace(): string|null
    {
        if (!$this->hasNamespace()) {
            $this->setNamespace($this->getDefaultNamespace());
        }
        return $this->namespace;
    }

    /**
     * Check if namespace has been set
     *
     * @return bool True if namespace has been set, false if not
     */
    public function hasNamespace(): bool
    {
        return isset($this->namespace);
    }

    /**
     * Get a default namespace value, if any is available
     *
     * @return string|null Default namespace value or null if no default value is available
     */
    public function getDefaultNamespace(): string|null
    {
        return null;
    }
}
