<?php

namespace Aedart\Contracts\Flysystem\Db;

use League\Flysystem\StorageAttributes;

/**
 * Record Types
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Flysystem\Db
 */
enum RecordTypes: string
{
    /**
     * Directory record type
     */
    case DIRECTORY = StorageAttributes::TYPE_DIRECTORY;

    /**
     * File record type
     */
    case FILE = StorageAttributes::TYPE_FILE;

    /**
     * List of supported record types
     */
    public static function allowed(): array
    {
        return [self::DIRECTORY, self::FILE];
    }
}