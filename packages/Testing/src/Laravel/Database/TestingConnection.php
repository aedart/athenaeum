<?php

namespace Aedart\Testing\Laravel\Database;

use Illuminate\Support\Facades\Config;

/**
 * Testing Connection
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Testing\Laravel\Database
 */
class TestingConnection
{
    /**
     * Adds and enables a "testing" database connection (by default, a sqlite in-memory connection)
     *
     * @param  string  $name  [optional]
     * @param  array  $options  [optional]
     *
     * @return void
     */
    public static function enableConnection(string $name = 'testing', array $options = []): void
    {
        $options = array_merge(
            static::defaultConnectionOptions(),
            $options
        );

        Config::set("database.connections.{$name}", $options);

        Config::set('database.default', $name);
    }

    /**
     * Default "testing" connection options
     *
     * @return array
     */
    public static function defaultConnectionOptions(): array
    {
        return [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'foreign_key_constraints' => true,
        ];
    }
}
