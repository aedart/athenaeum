<?php

namespace Aedart\Audit\Observers;

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
        //
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
        //
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
        //
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
        //
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
        //
    }
}