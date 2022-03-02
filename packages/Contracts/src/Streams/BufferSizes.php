<?php

namespace Aedart\Contracts\Streams;

/**
 * Buffer Sizes
 *
 * Defines a few "common" buffer sizes, in bytes.
 *
 * **Note**: _list of buffers size constants is not exhaustive, nor intended to be so!_
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Streams
 */
interface BufferSizes
{
    /**
     * 1 Kb / 1024 bytes buffer size
     */
    public const BUFFER_1KB = 1024;

    /**
     * 2 Kb buffer size
     */
    public const BUFFER_2KB = 2 * self::BUFFER_1KB;

    /**
     * 4 Kb buffer size
     */
    public const BUFFER_4KB = 4 * self::BUFFER_1KB;

    /**
     * 8 Kb buffer size
     */
    public const BUFFER_8KB = 8 * self::BUFFER_1KB;

    /**
     * 16 Kb buffer size
     */
    public const BUFFER_16KB = 16 * self::BUFFER_1KB;

    /**
     * 32 Kb buffer size
     */
    public const BUFFER_32KB = 32 * self::BUFFER_1KB;

    /**
     * 64 Kb buffer size
     */
    public const BUFFER_64KB = 64 * self::BUFFER_1KB;

    /**
     * 128 Kb buffer size
     */
    public const BUFFER_128KB = 128 * self::BUFFER_1KB;

    /**
     * 256 Kb buffer size
     */
    public const BUFFER_256KB = 256 * self::BUFFER_1KB;

    /**
     * 512 Kb buffer size
     */
    public const BUFFER_512KB = 512 * self::BUFFER_1KB;

    /**
     * 1 Mb / 1024 Kb buffer size
     */
    public const BUFFER_1MB = 1024 * self::BUFFER_1KB;

    /**
     * 2 Mb buffer size
     */
    public const BUFFER_2MB = 2 * self::BUFFER_1MB;
}
