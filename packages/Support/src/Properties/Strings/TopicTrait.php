<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Topic Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\TopicAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait TopicTrait
{
    /**
     * Name of topic
     *
     * @var string|null
     */
    protected string|null $topic = null;

    /**
     * Set topic
     *
     * @param string|null $name Name of topic
     *
     * @return self
     */
    public function setTopic(string|null $name): static
    {
        $this->topic = $name;

        return $this;
    }

    /**
     * Get topic
     *
     * If no topic value set, method
     * sets and returns a default topic.
     *
     * @see getDefaultTopic()
     *
     * @return string|null topic or null if no topic has been set
     */
    public function getTopic(): string|null
    {
        if (!$this->hasTopic()) {
            $this->setTopic($this->getDefaultTopic());
        }
        return $this->topic;
    }

    /**
     * Check if topic has been set
     *
     * @return bool True if topic has been set, false if not
     */
    public function hasTopic(): bool
    {
        return isset($this->topic);
    }

    /**
     * Get a default topic value, if any is available
     *
     * @return string|null Default topic value or null if no default value is available
     */
    public function getDefaultTopic(): string|null
    {
        return null;
    }
}
