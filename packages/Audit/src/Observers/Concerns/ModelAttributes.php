<?php


namespace Aedart\Audit\Observers\Concerns;

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
     * Returns model data via given method, or invokes the fallback callback
     *
     * @param Model $model
     * @param string $method Method to use for obtaining model's data (attributes)
     * @param callable $fallback Fallback method to use, in case method does not exist in given
     *                           model.
     *
     * @return array|null
     */
    protected function resolveModelData(Model $model, string $method, callable $fallback): ?array
    {
        if (method_exists($model, $method)) {
            return $model->{$method}();
        }

        return $fallback($model);
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