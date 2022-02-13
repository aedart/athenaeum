<?php

namespace Aedart\Contracts\Core;

use Closure;

/**
 * Environment Handler
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Core
 */
interface EnvironmentHandler
{
    /**
     * Get or check the current application environment.
     *
     * @see \Illuminate\Contracts\Foundation\Application::environment
     *
     * @param  string|array  $environments
     *
     * @return string|bool
     */
    public function environment(...$environments): string|bool;

    /**
     * Detect the application's current environment, using given callback
     *
     * @param  Closure  $callback
     *
     * @return string
     */
    public function detectEnvironment(Closure $callback): string;

    /**
     * Set the environment file to be loaded
     *
     * @param  string  $file
     *
     * @return self
     */
    public function loadEnvironmentFrom(string $file): static;

    /**
     * Get the fully qualified path to the environment file.
     *
     * @return string
     */
    public function environmentPath(): string;

    /**
     * Get the environment file the application is using.
     *
     * @return string
     */
    public function environmentFile(): string;

    /**
     * Get the fully qualified path to the environment file.
     *
     * @return string
     */
    public function environmentFilePath(): string;
}
