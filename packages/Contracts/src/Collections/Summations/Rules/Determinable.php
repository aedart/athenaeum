<?php


namespace Aedart\Contracts\Collections\Summations\Rules;

/**
 * Determinable
 *
 * Processing Rules that implement this interface are able
 * to determine whether or not given item can be processed.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Collections\Summations\Rules
 */
interface Determinable
{
    /**
     * Determine whether given item can be processed or not
     *
     * @param mixed $item
     *
     * @return bool
     */
    public function canProcess(mixed $item): bool;
}
