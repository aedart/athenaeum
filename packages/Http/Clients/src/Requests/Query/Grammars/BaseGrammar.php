<?php

namespace Aedart\Http\Clients\Requests\Query\Grammars;

use Aedart\Contracts\Http\Clients\Requests\Query\Builder;
use Aedart\Contracts\Http\Clients\Requests\Query\Grammar;

/**
 * Base Http Query Grammar
 *
 * Abstraction for Http Query Grammars
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Query\Grammars
 */
abstract class BaseGrammar implements Grammar
{
    /**
     * Grammar options
     *
     * @var array
     */
    protected array $options = [];

    /**
     * BaseGrammar constructor.
     *
     * @param array $options [optional]
     */
    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    /**
     * @inheritDoc
     */
    public function compile(Builder $builder): string
    {
        return '';
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

}
