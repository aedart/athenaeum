<?php

namespace Aedart\Contracts\Core\Helpers;

use Aedart\Contracts\Dto;

/**
 * Paths Container
 *
 * Keeps track of various application related paths
 *
 * @param string|null $path Base directory path
 * @param string|null $bootstrapPath Bootstrap directory path
 * @param string|null $configPath Config directory path
 * @param string|null $langPath Lang directory path
 * @param string|null $databasePath Database directory path
 * @param string|null $environmentPath Environment directory path
 * @param string|null $resourcePath Resource directory path
 * @param string|null $storagePath Storage directory path
 * @param string|null $publicPath Public directory path
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Core\Helpers
 */
interface PathsContainer extends Dto
{
    /**
     * Get a path within the "base" directory
     *
     * @param string $path [optional]
     *
     * @return string
     */
    public function basePath(string $path = ''): string;

    /**
     * Get a path within the "bootstrap" directory
     *
     * @param string $path [optional]
     *
     * @return string
     */
    public function bootstrapPath(string $path = ''): string;

    /**
     * Get a path within the "config" directory
     *
     * @param string $path [optional]
     *
     * @return string
     */
    public function configPath(string $path = ''): string;

    /**
     * Get path to language files.
     *
     * @param  string  $path
     *
     * @return string
     */
    public function langPath(string $path = ''): string;

    /**
     * Get a path with the "database" directory
     *
     * @param string $path [optional]
     *
     * @return string
     */
    public function databasePath(string $path = ''): string;

    /**
     * Get a path within the "environment" directory
     *
     * @param string $path [optional]
     *
     * @return string
     */
    public function environmentPath(string $path = ''): string;

    /**
     * Get a path within the "resources" directory
     *
     * @param string $path [optional]
     *
     * @return string
     */
    public function resourcePath(string $path = ''): string;

    /**
     * Get a path within the "storage" directory
     *
     * @param string $path [optional]
     *
     * @return string
     */
    public function storagePath(string $path = ''): string;

    /**
     * Get a path within the "public" directory
     *
     * @param string $path [optional]
     *
     * @return string
     */
    public function publicPath(string $path = ''): string;
}
