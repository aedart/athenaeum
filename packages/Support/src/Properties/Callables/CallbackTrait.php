<?php

namespace Aedart\Support\Properties\Callables;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Callback Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Callables\CallbackAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Callables
 */
trait CallbackTrait
{
    /**
     * Callback method
     *
     * @var callable|null
     */
    protected $callback = null;

    /**
     * Set callback
     *
     * @param callable|null $callback Callback method
     *
     * @return self
     */
    public function setCallback(callable|null $callback): static
    {
        $this->callback = $callback;

        return $this;
    }

    /**
     * Get callback
     *
     * If no callback value set, method
     * sets and returns a default callback.
     *
     * @see getDefaultCallback()
     *
     * @return callable|null callback or null if no callback has been set
     */
    public function getCallback(): callable|null
    {
        if (!$this->hasCallback()) {
            $this->setCallback($this->getDefaultCallback());
        }
        return $this->callback;
    }

    /**
     * Check if callback has been set
     *
     * @return bool True if callback has been set, false if not
     */
    public function hasCallback(): bool
    {
        return isset($this->callback);
    }

    /**
     * Get a default callback value, if any is available
     *
     * @return callable|null Default callback value or null if no default value is available
     */
    public function getDefaultCallback(): callable|null
    {
        return null;
    }
}
