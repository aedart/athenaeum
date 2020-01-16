<?php

namespace Aedart\Utils\Helpers;

use Illuminate\Support\Str;

/**
 * Method Helper
 *
 * <br />
 *
 * Offers various component methods or functions utilities.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Utils\Helpers
 */
class MethodHelper
{
    /**
     * Generates a 'getter' name for given property
     *
     * <b>Example</b><br />
     * <pre>
     *        $propertyName = 'logger';
     *        return makeGetterName($propertyName) // Returns getLogger
     * </pre>
     *
     * @param string $property
     *
     * @return string
     */
    public static function makeGetterName(string $property) : string
    {
        static $methods = [];

        return $methods[$property] ?? $methods[$property] = 'get' . ucfirst(Str::camel($property));
    }

    /**
     * Generates a 'setter' name for given property
     *
     * <b>Example</b><br />
     * <pre>
     *        $propertyName = 'logger';
     *        return makeGetterName($propertyName) // Returns setLogger
     * </pre>
     *
     * @param string $property
     *
     * @return string
     */
    public static function makeSetterName(string $property) : string
    {
        static $methods = [];

        return $methods[$property] ?? $methods[$property] = 'set' . ucfirst(Str::camel($property));
    }

    /**
     * Call the given method and return whatever method returns
     *
     * If given method is not callable, e.g. an integer is given,
     * then given value is returned instead
     *
     * @param mixed $method [optional] Callable method
     * @param array $parameters [optional] Evt. method arguments
     *
     * @return mixed Return value of given method or whatever was given if not callable
     */
    public static function callOrReturn($method = null, array $parameters = [])
    {
        if(is_callable($method)){
            return $method(...$parameters);
        }

        return $method;
    }
}
