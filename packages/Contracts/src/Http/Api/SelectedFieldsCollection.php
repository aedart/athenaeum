<?php

namespace Aedart\Contracts\Http\Api;

use ArrayAccess;
use Countable;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Selected Fields Collection
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Api
 */
interface SelectedFieldsCollection extends
    Arrayable,
    ArrayAccess,
    Countable
{
    /**
     * Determine if field is in this collection
     *
     * @param  string  $field
     *
     * @return bool
     */
    public function has(string $field): bool;

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
