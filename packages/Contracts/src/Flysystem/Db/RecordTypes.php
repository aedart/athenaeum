<?php

namespace Aedart\Contracts\Flysystem\Db;

/**
 * Record Types
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Contracts\Flysystem\Db
 */
interface RecordTypes
{
    /**
     * Directory record type
     */
    public const DIRECTORY = 'dir';

    /**
     * File record type
     */
    public const FILE = 'file';

    /**
     * List of supported record types
     */
    public const ALLOWED = [
        self::DIRECTORY,
        self::FILE
    ];
}