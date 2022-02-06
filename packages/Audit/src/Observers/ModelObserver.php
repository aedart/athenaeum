<?php

namespace Aedart\Audit\Observers;

use Aedart\Contracts\Audit\Types;
use Illuminate\Database\Eloquent\Model;
use Throwable;

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
    public bool $afterCommit = false;

    /**
     * Handle model "created" event.
     *
     * @param  Model  $model
     *
     * @return void
     *
     * @throws Throwable
     */
    public function created(Model $model)
    {
        $this->dispatchModelChanged($model, Types::CREATED);
    }

    /**
     * Handle model "updating" event. (Just before model is updated)
     *
     * @param  Model  $model
     *
     * @return void
     *
     * @throws Throwable
     */
    public function updating(Model $model)
    {
        $this->dispatchModelChanged($model, Types::UPDATED);
    }

    /**
     * Handle model "deleted" event.
     *
     * @param  Model  $model
     *
     * @return void
     *
     * @throws Throwable
     */
    public function deleted(Model $model)
    {
        // Avoid dispatching, if model is being force-deleted.
        // Force-deletes are handled in different method.
        if (method_exists($model, 'isForceDeleting') && $model->isForceDeleting()) {
            return;
        }

        $this->dispatchModelChanged($model, Types::DELETED);
    }

    /**
     * Handle model "restored" event.
     *
     * @param  Model  $model
     *
     * @return void
     *
     * @throws Throwable
     */
    public function restored(Model $model)
    {
        $this->dispatchModelChanged($model, Types::RESTORED);
    }

    /**
     * Handle model "force deleted" event.
     *
     * @param  Model  $model
     *
     * @return void
     *
     * @throws Throwable
     */
    public function forceDeleted(Model $model)
    {
        $this->dispatchModelChanged($model, Types::FORCE_DELETED);
    }
}
