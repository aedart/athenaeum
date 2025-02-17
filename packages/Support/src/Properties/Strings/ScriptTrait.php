<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Script Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\ScriptAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait ScriptTrait
{
    /**
     * Script of some kind or path to some script
     *
     * @var string|null
     */
    protected string|null $script = null;

    /**
     * Set script
     *
     * @param string|null $script Script of some kind or path to some script
     *
     * @return self
     */
    public function setScript(string|null $script): static
    {
        $this->script = $script;

        return $this;
    }

    /**
     * Get script
     *
     * If no script value set, method
     * sets and returns a default script.
     *
     * @see getDefaultScript()
     *
     * @return string|null script or null if no script has been set
     */
    public function getScript(): string|null
    {
        if (!$this->hasScript()) {
            $this->setScript($this->getDefaultScript());
        }
        return $this->script;
    }

    /**
     * Check if script has been set
     *
     * @return bool True if script has been set, false if not
     */
    public function hasScript(): bool
    {
        return isset($this->script);
    }

    /**
     * Get a default script value, if any is available
     *
     * @return string|null Default script value or null if no default value is available
     */
    public function getDefaultScript(): string|null
    {
        return null;
    }
}
