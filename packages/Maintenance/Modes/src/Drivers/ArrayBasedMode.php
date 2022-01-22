<?php

namespace Aedart\Maintenance\Modes\Drivers;

use Illuminate\Contracts\Foundation\MaintenanceMode;

/**
 * Array Based Maintenance Mode
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Maintenance\Modes\Drivers
 */
class ArrayBasedMode implements MaintenanceMode
{
    /**
     * Active maintenance mode payload.
     *
     * @var array|null
     */
    protected static array|null $active = null;

    /**
     * @inheritDoc
     */
    public function activate(array $payload): void
    {
        static::$active = $payload;
    }

    /**
     * @inheritDoc
     */
    public function deactivate(): void
    {
        static::$active = null;
    }

    /**
     * @inheritDoc
     */
    public function active(): bool
    {
        return static::$active !== null;
    }

    /**
     * @inheritDoc
     */
    public function data(): array
    {
        // Edge-case: data is requested, but no maintenance mode payload!
        if (!$this->active()) {
            return [];
        }

        return static::$active;
    }
}
