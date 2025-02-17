<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Topic Aware
 *
 * Component is aware of string "topic"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface TopicAware
{
    /**
     * Set topic
     *
     * @param string|null $name Name of topic
     *
     * @return self
     */
    public function setTopic(string|null $name): static;

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
    public function getTopic(): string|null;

    /**
     * Check if topic has been set
     *
     * @return bool True if topic has been set, false if not
     */
    public function hasTopic(): bool;

    /**
     * Get a default topic value, if any is available
     *
     * @return string|null Default topic value or null if no default value is available
     */
    public function getDefaultTopic(): string|null;
}
