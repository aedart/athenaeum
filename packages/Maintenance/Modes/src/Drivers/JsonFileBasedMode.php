<?php

namespace Aedart\Maintenance\Modes\Drivers;

use Aedart\Utils\Json;
use Illuminate\Contracts\Foundation\MaintenanceMode;

/**
 * Json File Based Mode
 *
 * Acts as an alternative to Laravel's default "file based" maintenance mode.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Maintenance\Modes\Drivers
 */
class JsonFileBasedMode implements MaintenanceMode
{
    /**
     * Storage path for json file
     *
     * @var string
     */
    protected string $path;

    /**
     * Json encoding options
     *
     * @var int
     */
    protected int $options;

    /**
     * Create new Json file based maintenance mode
     *
     * @param  string  $path Location where maintenance file for "down" must be stored
     * @param  int  $options  [optional] Json encoding options
     */
    public function __construct(string $path, int $options = JSON_PRETTY_PRINT)
    {
        $this->path = $path;
        $this->options = $options;
    }

    /**
     * @inheritDoc
     */
    public function activate(array $payload): void
    {
        $encoded = Json::encode($payload, $this->options);

        file_put_contents($this->path, $encoded);
    }

    /**
     * @inheritDoc
     */
    public function deactivate(): void
    {
        if ($this->active()) {
            unlink($this->path);
        }
    }

    /**
     * @inheritDoc
     */
    public function active(): bool
    {
        return file_exists($this->path);
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

        return Json::decode(file_get_contents($this->path), true);
    }
}
