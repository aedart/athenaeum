<?php


namespace Aedart\Audit\Observers\Concerns;

use Aedart\Audit\Concerns\CallbackReason;
use Aedart\Utils\Helpers\Invoker;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Throwable;

/**
 * Concerns Model Attributes
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Audit\Observers\Concerns
 */
trait ModelAttributes
{
    use CallbackReason;

    /**
     * Resolves the given model's original data (attributes)
     *
     * @param Model $model
     * @param string $type
     *
     * @return mixed
     *
     * @throws Throwable
     */
    protected function resolveOriginalData(Model $model, string $type): mixed
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
     * @throws Throwable
     */
    protected function resolveChangedData(Model $model, string $type): mixed
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
    protected function reduceOriginal(array|null $original, array|null $changed): array|null
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
    protected function resolveAuditTrailMessage(Model $model, string $type): string|null
    {
        // Resolve message from "callback", when one exists
        $callbackReason = $this->callbackReason();
        if ($callbackReason->exists()) {
            return $callbackReason->resolve($model, $type);
        }

        // Otherwise, use model's audit trail message
        if (method_exists($model, 'getAuditTrailMessage')) {
            return $model->getAuditTrailMessage($type);
        }

        return null;
    }

    /**
     * Format the given date time
     *
     * @param DateTimeInterface $date
     *
     * @return string
     */
    protected function formatDatetime(DateTimeInterface $date): string
    {
        return $date->format(DateTimeInterface::RFC3339);
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
