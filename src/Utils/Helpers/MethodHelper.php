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
    static public function makeGetterName(string $property) : string
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
    static public function makeSetterName(string $property) : string
    {
        static $methods = [];

        return $methods[$property] ?? $methods[$property] = 'set' . ucfirst(Str::camel($property));
    }
}
