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
    public function when(bool|callable $result, callable $callback, callable|null $otherwise = null): static
    {
        if (is_callable($result)) {
            $result = $result($this);
        }

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
    public function unless(bool|callable $result, callable $callback, callable|null $otherwise = null): static
    {
        if (is_callable($result)) {
            $result = $result($this);
        }

        return $this->when(!$result, $callback, $otherwise);
    }
}
