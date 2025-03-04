<?php

namespace Aedart\Contracts\Streams;

/**
 * Buffer Sizes
 *
 * Defines a few "common" buffer sizes, in bytes.
 *
 * **Note**: _List of buffers sizes is not exhaustive, nor intended to be so!_
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Streams
 */
interface BufferSizes
{
    /**
     * 1 kB / 1024 bytes buffer size
     */
    public const int BUFFER_1KB = 1024;

    /**
     * 2 kB buffer size
     */
    public const int|float BUFFER_2KB = 2 * self::BUFFER_1KB;

    /**
     * 4 kB buffer size
     */
    public const int|float BUFFER_4KB = 4 * self::BUFFER_1KB;

    /**
     * 8 kB buffer size
     */
    public const int|float BUFFER_8KB = 8 * self::BUFFER_1KB;

    /**
     * 16 kB buffer size
     */
    public const int|float BUFFER_16KB = 16 * self::BUFFER_1KB;

    /**
     * 32 kB buffer size
     */
    public const int|float BUFFER_32KB = 32 * self::BUFFER_1KB;

    /**
     * 64 kB buffer size
     */
    public const int|float BUFFER_64KB = 64 * self::BUFFER_1KB;

    /**
     * 128 kB buffer size
     */
    public const int|float BUFFER_128KB = 128 * self::BUFFER_1KB;

    /**
     * 256 kB buffer size
     */
    public const int|float BUFFER_256KB = 256 * self::BUFFER_1KB;

    /**
     * 512 kB buffer size
     */
    public const int|float BUFFER_512KB = 512 * self::BUFFER_1KB;

    /**
     * 1 MB / 1024 kB buffer size
     */
    public const int|float BUFFER_1MB = 1024 * self::BUFFER_1KB;
}
