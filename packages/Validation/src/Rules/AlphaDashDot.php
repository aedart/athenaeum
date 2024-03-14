<?php

namespace Aedart\Validation\Rules;

use Closure;

/**
 * Alpha Dash Dot
 *
 * Ensures attribute is an alphanumeric string, allowing dashes, underscores and
 * dots.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Acl\Rules
 */
class AlphaDashDot extends BaseValidationRule
{
    /**
     * @inheritDoc
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->isValid($value)) {
            $fail('athenaeum-validation::messages.alpha_dash_dot')->translate([
                'attribute' => $attribute
            ]);
        }
    }

    /**
     * Determine if value is valid
     *
     * @param mixed $value
     *
     * @return bool
     */
    public function isValid(mixed $value): bool
    {
        // Ensure that value is string or numeric
        if (!is_string($value) && !is_numeric($value)) {
            return false;
        }

        // This rule is very similar to the "alpha dash" rule, yet with
        // a single addition: dot (period) is also allowed.
        return preg_match('/^[\pL\pM\pN._-]+$/u', $value) > 0;
    }
}
