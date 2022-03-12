<?php

namespace Aedart\Contracts\Streams\Hashing;

use Aedart\Contracts\Streams\Exceptions\StreamException;

/**
 * Hashable
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Streams\Hashing
 */
interface Hashable
{
    /**
     * Return a hash of stream's contents
     *
     * @see https://www.php.net/manual/en/function.hash-init.php
     * @see https://www.php.net/manual/en/function.hash-update-stream.php
     * @see https://www.php.net/manual/en/function.hash-final.php
     *
     * @param  string  $algo Name of hashing algorithm
     * @param  bool  $binary  [optional] If true, outputs raw binary data
     * @param  int  $flags  [optional] Optional settings for hash generation
     * @param  string  $key  [optional] Shared secret key, when HASH_HMAC specified in `$flags`
     * @param  array  $options  [optional] Options for the specified hashing algorithm
     *
     * @return string
     *
     * @throws StreamException
     */
    public function hash(
        string $algo,
        bool $binary = false,
        int $flags = 0,
        string $key = '',
        array $options = []
    ): string;
}
