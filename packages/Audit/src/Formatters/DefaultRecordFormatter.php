<?php

namespace Aedart\Audit\Formatters;

use Aedart\Contracts\Audit\RecordData;

/**
 * Default Audit Trail Record Formatter
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Audit\Formatters
 */
class DefaultRecordFormatter extends BaseFormatter
{
    /**
     * @inheritdoc
     */
    public function format(
        string $type,
        array|null $original = null,
        array|null $changed = null,
        string|null $message = null,
    ): RecordData {
        $original = $original ?? $this->originalData($type);
        $changed = $changed ?? $this->changedData($type);
        $message = $message ?? $this->message($type);

        $original = $this->reduceOriginal($original, $changed);

        return $this->makeRecordData($original, $changed, $message);
    }
}
