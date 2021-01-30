<?php

namespace Aedart\Contracts\Collections\Summations\Rules;

use Countable;
use Illuminate\Contracts\Support\Arrayable;
use IteratorAggregate;

/**
 * Processing Rules Repository
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Collections\Summations\Rules
 */
interface Repository extends
    Countable,
    Arrayable,
    IteratorAggregate
{
    /**
     * Returns collection of processing rules that
     * can process given item
     *
     * @see Determinable
     *
     * @param mixed $item
     *
     * @return Rules
     */
    public function matching($item): Rules;

    /**
     * Returns collection of all processing rules,
     *
     * @return Rules
     */
    public function all(): Rules;
}
