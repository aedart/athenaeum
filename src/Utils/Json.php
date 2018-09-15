<?php

namespace Aedart\Utils;

use Aedart\Utils\Exceptions\JsonEncoding;

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
     * @throws JsonEncoding
     */
    static public function encode($value, int $options = 0, int $depth = 512) : string
    {
        $encoded = json_encode($value, $options, $depth);

        if(json_last_error() !== JSON_ERROR_NONE){
            throw new JsonEncoding(json_last_error_msg());
        }

        return $encoded;
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
     * @throws JsonEncoding
     */
    static public function decode(
        string $json,
        bool $assoc = false,
        int $depth = 512,
        int $options = 0
    ) {
        $decoded = json_decode($json, $assoc, $depth, $options);

        if(json_last_error() !== JSON_ERROR_NONE){
            throw new JsonEncoding(json_last_error_msg());
        }

        return $decoded;
    }
}
