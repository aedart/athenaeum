<?php

namespace Aedart\Contracts\Flysystem\Db;

use League\Flysystem\StorageAttributes;

/**
 * Record Types
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Flysystem\Db
 */
interface RecordTypes
{
    /**
     * Directory record type
     */
    public const DIRECTORY = StorageAttributes::TYPE_DIRECTORY;

    /**
     * File record type
     */
    public const FILE = StorageAttributes::TYPE_FILE;

    /**
     * List of supported record types
     */
    public const ALLOWED = [
        self::DIRECTORY,
        self::FILE
    ];
}
