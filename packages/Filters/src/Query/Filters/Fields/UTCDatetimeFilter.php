<?php

namespace Aedart\Filters\Query\Filters\Fields;

use Aedart\Contracts\Database\Query\FieldCriteria;

/**
 * UTC Datetime Filter
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Filters\Query\Filters\Fields
 */
class UTCDatetimeFilter extends DatetimeFilter
{
    /**
     * @inheritDoc
     */
    public function __construct(
        string|null $field = null,
        string|null $operator = null,
        mixed $value = null,
        string $logical = FieldCriteria::AND
    ) {
        parent::__construct($field, $operator, $value, $logical);

        $this->convertToUtc(true);
    }
}
