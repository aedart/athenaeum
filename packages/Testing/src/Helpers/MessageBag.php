<?php


namespace Aedart\Testing\Helpers;

/**
 * Message Bag
 *
 * A simple message bag, intended to be used across components, during tests
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Testing\Helpers
 */
class MessageBag
{
    /**
     * Messages
     *
     * @var string[]
     */
    protected static array $messages = [];

    /**
     * Add a message
     *
     * @param string $message
     */
    public static function add(string $message): void
    {
        static::$messages[] = $message;
    }

    /**
     * Get all messages
     *
     * @return string[]
     */
    public static function all(): array
    {
        return static::$messages;
    }

    /**
     * Clear all messages
     */
    public static function clearAll(): void
    {
        static::$messages = [];
    }
}
