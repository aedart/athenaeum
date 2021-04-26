<?php

namespace Aedart\Audit\Observers;

use Aedart\Audit\Observers\Concerns;
use Aedart\Contracts\Audit\Types;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Observer
 *
 * Responsible for delegating Eloquent Model event, by dispatching
 * "has changed" event
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Audit\Observers
 */
class ModelObserver
{
    use Concerns\ModelChangedEvents;

    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;

    /**
     * Handle model "created" event.
     *
     * @param Model $model
     *
     * @return void
     */
    public function created(Model $model)
    {
        $this->dispatchModelChanged($model, Types::CREATED);
    }

    /**
     * Handle model "updated" event.
     *
     * @param Model $model
     *
     * @return void
     */
    public function updated(Model $model)
    {
        $this->dispatchModelChanged($model, Types::UPDATED);
    }

    /**
     * Handle model "deleted" event.
     *
     * @param Model $model
     *
     * @return void
     */
    public function deleted(Model $model)
    {
        $this->dispatchModelChanged($model, Types::DELETED);
    }

    /**
     * Handle model "restored" event.
     *
     * @param Model $model
     *
     * @return void
     */
    public function restored(Model $model)
    {
        $this->dispatchModelChanged($model, Types::RESTORED);
    }

    /**
     * Handle model "force deleted" event.
     *
     * @param Model $model
     *
     * @return void
     */
    public function forceDeleted(Model $model)
    {
        $this->dispatchModelChanged($model, Types::FORCE_DELETED);
    }
}