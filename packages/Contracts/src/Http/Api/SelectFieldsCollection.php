<?php

namespace Aedart\Contracts\Http\Api;

use ArrayAccess;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Select Fields Collection
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Api
 */
interface SelectFieldsCollection extends Arrayable,
     ArrayAccess
{
    /**
     * Determine if this collection is empty
     *
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * Determine if this collection is not empty
     *
     * @return bool
     */
    public function isNotEmpty(): bool;
}