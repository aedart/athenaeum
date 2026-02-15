<?php

namespace Aedart\Contracts\Audit;

/**
 * Audit Trail Entry / Record Formatter
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Audit
 */
interface Formatter
{
    /**
     * Formats given original and changed data for Audit Trail entry
     *
     * @param  string  $type Event type
     * @param  array|null  $original  [optional] Default's to given model's original data, if none given.
     * @param  array|null  $changed  [optional] Default's to given model's changed data, if none given.
     * @param  string|null  $message  [optional] Eventual message associated with the change
     *
     * @return RecordData
     */
    public function format(
        string $type,
        array|null $original = null,
        array|null $changed = null,
        string|null $message = null,
    ): RecordData;

    /**
     * Returns the model for this formatter
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getModel();
}
