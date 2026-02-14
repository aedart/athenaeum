<?php

namespace Aedart\Tests\Helpers\Dummies\Audit\Formatters;

use Aedart\Audit\Formatters\BaseFormatter;
use Aedart\Utils\Math;
use Throwable;

/**
 * Category Audit Trail Formatter
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Helpers\Dummies\Audit\Formatters
 */
class CategoryAuditTrailFormatter extends BaseFormatter
{
    /**
     * @inheritdoc
     */
    public function formatMessage(string $type, string|null $message = null): string|null
    {
        if (isset($message)) {
            return strtoupper($message);
        }

        return $message;
    }

    /**
     * @inheritdoc
     * @throws Throwable
     */
    public function formatOriginal(array|null $data, string $type): array|null
    {
        return $this->formatData($data);
    }

    /**
     * @inheritdoc
     * @throws Throwable
     */
    public function formatChanged(array|null $data, string $type): array|null
    {
        return $this->formatData($data);
    }

    /**
     * Custom...
     *
     * @param  array|null  $data  [optional]
     * @return array
     *
     * @throws Throwable
     */
    public function formatData(array|null $data): array
    {
        $data = $data ?? [];

        $data['extra'] = Math::randomizer()->int(0, 10);

        return $data;
    }
}
