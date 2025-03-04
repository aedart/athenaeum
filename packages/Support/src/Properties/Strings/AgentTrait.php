<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Agent Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\AgentAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait AgentTrait
{
    /**
     * Someone or something that acts on behalf of someone else or something else
     *
     * @var string|null
     */
    protected string|null $agent = null;

    /**
     * Set agent
     *
     * @param string|null $agent Someone or something that acts on behalf of someone else or something else
     *
     * @return self
     */
    public function setAgent(string|null $agent): static
    {
        $this->agent = $agent;

        return $this;
    }

    /**
     * Get agent
     *
     * If no agent value set, method
     * sets and returns a default agent.
     *
     * @see getDefaultAgent()
     *
     * @return string|null agent or null if no agent has been set
     */
    public function getAgent(): string|null
    {
        if (!$this->hasAgent()) {
            $this->setAgent($this->getDefaultAgent());
        }
        return $this->agent;
    }

    /**
     * Check if agent has been set
     *
     * @return bool True if agent has been set, false if not
     */
    public function hasAgent(): bool
    {
        return isset($this->agent);
    }

    /**
     * Get a default agent value, if any is available
     *
     * @return string|null Default agent value or null if no default value is available
     */
    public function getDefaultAgent(): string|null
    {
        return null;
    }
}
