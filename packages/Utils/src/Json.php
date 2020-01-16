<?php

namespace Aedart\Utils;

use JsonException;

/**
 * Json Utility
 *
 * <br />
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
     * @param int $options [optional] Bitmask
     * @param int $depth [optional] Maximum depth. Must be greater than zero
     *
     * @return string
     *
     * @throws JsonException
     */
    public static function encode($value, int $options = 0, int $depth = 512) : string
    {
        return json_encode($value, $options |= JSON_THROW_ON_ERROR, $depth);
    }

    /**
     * Decodes given Json string
     *
     * @link https://secure.php.net/manual/en/function.json-decode.php
     *
     * @param string $json The json string being decoded
     * @param bool $assoc [optional] Returns array, if true
     * @param int $depth [optional] Recursion depth
     * @param int $options [optional] Bitmask
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
    ) {
        return json_decode($json, $assoc, $depth, $options |= JSON_THROW_ON_ERROR);
    }
}
