<?php

namespace Aedart\Utils;

use JsonException;

/**
 * Json Utility
 *
 * Offers various Json utilities.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Utils
 */
class Json
{
    /**
     * Returns the Json representation of value
     *
     * @link https://secure.php.net/manual/en/function.json-encode.php
     *
     * @param mixed $value The value being encoded. Can be any type except a resource
     * @param int $options [optional] {@see JSON_THROW_ON_ERROR} always added to given options
     * @param int $depth [optional] Maximum depth. Must be greater than zero
     *
     * @return string
     *
     * @throws JsonException
     */
    public static function encode(mixed $value, int $options = 0, int $depth = 512): string
    {
        $options |= JSON_THROW_ON_ERROR;

        return json_encode($value, $options, $depth);
    }

    /**
     * Decodes given Json string
     *
     * @link https://secure.php.net/manual/en/function.json-decode.php
     *
     * @param string $json The json string being decoded
     * @param bool $assoc [optional] Returns array, if true
     * @param int $depth [optional] Recursion depth
     * @param int $options [optional] {@see JSON_THROW_ON_ERROR} always added to given options
     *
     * @return mixed
     *
     * @throws JsonException
     */
    public static function decode(
        string $json,
        bool $assoc = false,
        int $depth = 512,
        int $options = 0
    ): mixed {
        $options |= JSON_THROW_ON_ERROR;

        return json_decode($json, $assoc, $depth, $options);
    }

    /**
     * Determine if given value is a valid json encoded string
     *
     * @param  mixed  $value
     *
     * @return bool False if not a string or if invalid encoded json
     */
    public static function isValid(mixed $value): bool
    {
        if (!is_string($value)) {
            return false;
        }

        @json_decode($value);

        return json_last_error() === JSON_ERROR_NONE;
    }
}
