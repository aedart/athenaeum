<?php

namespace Aedart\Http\Clients\Requests\Builders\Concerns;

use Aedart\Contracts\Http\Clients\Requests\Builder;

/**
 * Concerns Conditions
 *
 * @see Builder
 * @see Builder::when
 * @see Builder::unless
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Concerns
 */
trait Conditions
{
    /**
     * Apply a callback, when result is true
     *
     * Method is inverse of {@see unless}.
     *
     * Any value returned by the callback methods, is ignored.
     *
     * @param bool $result E.g. the boolean result of a condition
     * @param callable $callback The callback to apply, if result is `true`.
     *                          Request builder instance is given as callback's argument.
     * @param callable|null $otherwise [optional] Callback to apply, if result evaluates is `false`.
     *                          Request builder instance is given as callback's argument.
     *
     * @return self
     */
    public function when(bool $result, callable $callback, ?callable $otherwise = null): Builder
    {
        if ($result === true) {
            $callback($this);
        } elseif (isset($otherwise)) {
            $otherwise($this);
        }

        return $this;
    }

    /**
     * Apply a callback, unless result is true
     *
     * Method is inverse of {@see when}.
     *
     * Any value returned by the callback methods, is ignored.
     *
     * @param bool $result E.g. the boolean result of a condition
     * @param callable $callback The callback to apply, if result is `false`.
     *                          Request builder instance is given as callback's argument.
     * @param callable|null $otherwise [optional] Callback to apply, if result evaluates is `true`.
     *                          Request builder instance is given as callback's argument.
     *
     * @return self
     */
    public function unless(bool $result, callable $callback, ?callable $otherwise = null): Builder
    {
        return $this->when(!$result, $callback, $otherwise);
    }
}
