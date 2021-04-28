<?php


namespace Aedart\Audit\Observers\Concerns;

use Aedart\Utils\Helpers\Invoker;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Concerns Model Attributes
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Audit\Observers\Concerns
 */
trait ModelAttributes
{
    /**
     * Resolves the given model's original data (attributes)
     *
     * @param Model $model
     * @param string $type
     *
     * @return mixed
     *
     * @throws \Throwable
     */
    protected function resolveOriginalData(Model $model, string $type)
    {
        return Invoker::invoke([$model, 'originalData'])
            ->with($type)
            ->fallback(function () use ($model) {
                return $model->getOriginal();
            })
            ->call();
    }

    /**
     * Resolves the given model's changed data (attributes)
     *
     * @param Model $model
     * @param string $type
     *
     * @return mixed
     *
     * @throws \Throwable
     */
    protected function resolveChangedData(Model $model, string $type)
    {
        return Invoker::invoke([$model, 'changedData'])
            ->with($type)
            ->fallback(function () use ($model) {
                return $model->getChanges();
            })
            ->call();
    }

    /**
     * Reduce original attributes, by excluding attributes that have not been changed.
     *
     * @param array|null $original
     * @param array|null $changed
     *
     * @return array|null
     */
    protected function reduceOriginal(?array $original, ?array $changed): ?array
    {
        if (!empty($original) && !empty($changed)) {
            return $this->pluck(array_keys($changed), $original);
        }

        return $original;
    }

    /**
     * Resolve the Audit Trail Message, if possible
     *
     * @param Model $model
     * @param string $type
     *
     * @return string|null
     */
    protected function resolveAuditTrailMessage(Model $model, string $type): ?string
    {
        if (method_exists($model, 'getAuditTrailMessage')) {
            return $model->getAuditTrailMessage($type);
        }

        return null;
    }

    /**
     * Resolves the performed at datetime, using given model
     *
     * @param Model $model
     * @param DateTimeInterface|Carbon|string|null $performedAt [optional]
     *
     * @return Carbon|DateTimeInterface|string
     */
    protected function resolvePerformedAtUsing(Model $model, $performedAt = null)
    {
        if (isset($performedAt)) {
            return Carbon::make($performedAt);
        }

        $column = $model->getUpdatedAtColumn();
        if (!empty($model->{$column})) {
            return $model->{$column};
        }

        return Carbon::now();
    }

    /**
     * Plucks items from target that match given keys
     *
     * @param string[] $keys The keys to pluck from target
     * @param array $target
     *
     * @return array
     */
    protected function pluck(array $keys, array $target): array
    {
        return collect($target)
            ->only($keys)
            ->toArray();
    }
}
