<?php

namespace Aedart\Audit\Formatters;

use Aedart\Contracts\Audit\RecordData;
use Aedart\Utils\Helpers\Invoker;
use Illuminate\Database\Eloquent\Model;
use Throwable;

/**
 * Legacy Audit Trail Record Formatter
 *
 * @deprecated Since v10.x, Replaced by {@see \Aedart\Audit\Formatters\DefaultRecordFormatter}
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Audit\Formatters
 */
class LegacyRecordFormatter extends BaseFormatter
{
    /**
     * @inheritdoc
     *
     * @throws Throwable
     */
    public function format(
        string $type,
        array|null $original = null,
        array|null $changed = null,
        string|null $message = null,
    ): RecordData {
        $model = $this->getModel();

        $original = $original ?? $this->resolveOriginalData($model, $type);
        $changed = $changed ?? $this->resolveChangedData($model, $type);
        $message = $message ?? $this->message($type);

        $original = $this->reduceOriginal($original, $changed);

        return $this->makeRecordData($original, $changed, $message);
    }

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
}
