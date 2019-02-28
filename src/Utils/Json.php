<?php

namespace Aedart\Utils;

use Aedart\Utils\Exceptions\JsonEncoding;
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
    static public function encode($value, int $options = 0, int $depth = 512) : string
    {
        $options = static::resolveThrowExceptionBitmask($options);

        try {
            return json_encode($value, $options, $depth);
        } catch (JsonException $e) {
            throw new JsonEncoding($e->getMessage(), $e->getCode(), $e);
        }
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
    static public function decode(
        string $json,
        bool $assoc = false,
        int $depth = 512,
        int $options = 0
    ) {
        $options = static::resolveThrowExceptionBitmask($options);

        try {
            return json_decode($json, $assoc, $depth, $options);
        } catch (JsonException $e) {
            throw new JsonEncoding($e->getMessage(), $e->getCode(), $e);
        }
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Add the "throw on error" bitmask option, if required
     *
     * @see http://php.net/manual/en/json.constants.php
     *
     * @param int $options Json encode / decode bitmask options
     *
     * @return int
     */
    static protected function resolveThrowExceptionBitmask(int $options) : int
    {
        if($options & JSON_THROW_ON_ERROR){
            return $options;
        }

        return $options | JSON_THROW_ON_ERROR;
    }
}
