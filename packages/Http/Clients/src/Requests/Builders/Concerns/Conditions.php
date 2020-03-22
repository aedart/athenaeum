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
     * @inheritdoc
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
     * @inheritdoc
     */
    public function unless(bool $result, callable $callback, ?callable $otherwise = null): Builder
    {
        return $this->when(!$result, $callback, $otherwise);
    }
}
