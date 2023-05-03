<?php

namespace Aedart\Validation\Rules;

use Carbon\Exceptions\InvalidFormatException;
use Closure;
use Illuminate\Support\Carbon;
use ValueError;

/**
 * Date Format Validation Rule
 *
 * Ensures given attribute is a date string according to an allowed format.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Validation\Rules
 */
class DateFormat extends BaseValidationRule
{
    /**
     * Allowed formats
     *
     * @var string[]
     */
    protected array $formats;

    /**
     * Create new instance of validation rule
     *
     * @param string ...$formats
     */
    public function __construct(...$formats)
    {
        $this->formats = $formats;
    }

    /**
     * @inheritDoc
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->isValid($value)) {
            $fail('validation.date_format')->translate([
                'attribute' => $attribute,
                'format' => $this->formats[0]
            ]);
        }
    }

    /**
     * Determine if given date is valid (can be created acc. to allowed format)
     *
     * @param mixed $value
     *
     * @return bool
     */
    public function isValid(mixed $value): bool
    {
        if (empty($value) || (!is_string($value) && !is_numeric($value))) {
            return false;
        }

        foreach ($this->formats as $format) {
            try {
                $date = Carbon::createFromFormat('!' . $format, $value);

                // Skip to next format, if unable to create by format
                if ($date === false) {
                    continue;
                }

                // Pass, if exported format matches the string date (just like Laravel's
                // 'date_format' validation rule )
                if ($date->format($format) == $value) {
                    return true;
                }

                // Edge-case: if the format contains 'p' token (timezone offset), e.g. RCF 3339 Extended Zulu,
                // then the "format()" output comparison might fail if +00:00 timezone offset is submitted.
                // The output of the format converts +00:00 to 'Z', which then fails format output comparison.
                if (
                    (str_contains($format, 'p') && !str_contains($format, '\\p'))           // Only when unescaped 'p' token is present
                    && (str_ends_with($value, '+00:00') || str_ends_with($value, '-00:00'))
                    && $date->eq($value)
                ) {
                    return true;
                }
            } catch (ValueError|InvalidFormatException $e) {
                // Ignore value error / format exceptions. This is important when there are multiple
                // allowed formats...
                continue;
            }
        }

        return false;
    }
}
