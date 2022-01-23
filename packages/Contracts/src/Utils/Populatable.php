<?php

namespace Aedart\Contracts\Utils;

use Throwable;

/**
 * Populatable
 *
 * Able to be populated (hydrated) with data.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Utils
 */
interface Populatable
{
    /**
     * Populate this component via an array
     *
     * If an empty array is provided, nothing is populated.
     *
     * If a value or property is not given via $data, then it
     * is NOT modified / changed.
     *
     * Example:
     * ```
     *      $myComponent->populate([
     *          'myProperty' => 'myPropertyValue',
     *          'myOtherProperty' => 42.5
     *      ])
     * ```
     *
     * @param array $data [optional] Key-value pair, key = property name, value = property value
     *
     * @return void
     *
     * @throws Throwable In case that one or more of the given array entries are invalid
     */
    public function populate(array $data = []): void;
}
