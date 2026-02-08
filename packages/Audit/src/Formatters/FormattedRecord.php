<?php

namespace Aedart\Audit\Formatters;

use Aedart\Contracts\Audit\RecordData;

/**
 * Formatted Audit Trail Record Data
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Audit\Formatters
 */
class FormattedRecord implements RecordData
{
    /**
     * Create new formatted record data instance
     *
     * @param  array|null  $original  [optional]
     * @param  array|null  $changed  [optional]
     * @param  string|null  $message  [optional]
     */
    public function __construct(
        protected array|null $original = null,
        protected array|null $changed = null,
        protected string|null $message = null,
    ) {
    }

    /**
     * @inheritdoc
     */
    public function original(): array|null
    {
        return $this->original;
    }

    /**
     * @inheritdoc
     */
    public function changed(): array|null
    {
        return $this->changed;
    }

    /**
     * @inheritdoc
     */
    public function message(): string|null
    {
        return $this->message;
    }
}
