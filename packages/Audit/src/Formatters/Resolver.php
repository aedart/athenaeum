<?php

namespace Aedart\Audit\Formatters;

use Aedart\Contracts\Audit\Formatter;
use Aedart\Support\Facades\IoCFacade;
use Illuminate\Database\Eloquent\Model;
use LogicException;

/**
 * Audit Trail Record Formatter Resolver
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Audit\Formatters
 */
class Resolver
{
    /**
     * Resolves an Audit Trail Record Formatter for the given model
     *
     * @param  Model  $model
     *
     * @return Formatter
     */
    public static function resolve(Model $model): Formatter
    {
        $formatter = match (true) {
            method_exists($model, 'auditTrailRecordFormatter') => $model->auditTrailRecordFormatter(),
            default => static::makeDefaultFormatter($model),
        };

        return match (true) {
            $formatter instanceof Formatter => $formatter,
            is_null($formatter) => static::makeDefaultFormatter($model),
            is_string($formatter) && class_exists($formatter) => new $formatter($model),
            is_string($formatter) && !class_exists($formatter) => throw new LogicException(sprintf('Invalid Audit Trail Formatter class path "%s", for model %s', $formatter, $model::class)),
            default => throw new LogicException(sprintf('Unable to resolve Audit Trail Record Formatter for model %s', $model::class))
        };
    }

    /**
     * Returns a default audit trail record formatter
     *
     * @param  Model  $model
     *
     * @return Formatter
     */
    public static function makeDefaultFormatter(Model $model): Formatter
    {
        return IoCFacade::make(Formatter::class, compact('model'));
    }
}
