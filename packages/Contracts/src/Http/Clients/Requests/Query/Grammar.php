<?php


namespace Aedart\Contracts\Http\Clients\Requests\Query;

/**
 * Http Query Grammar
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Clients\Requests\Query
 */
interface Grammar
{
    /**
     * Compiles a http query string
     *
     * @param Builder $builder
     *
     * @return string
     */
    public function compile(Builder $builder): string;
}
