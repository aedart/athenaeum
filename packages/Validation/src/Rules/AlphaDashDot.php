<?php

namespace Aedart\Validation\Rules;

/**
 * Alpha Dash Dot
 *
 * Ensures attribute is an alphanumeric string, allowing dashes, underscores and
 * dots.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Acl\Rules
 */
class AlphaDashDot extends BaseRule
{
    use Concerns\AthenaeumRule;

    /**
     * Creates a new alpha-dash-dot validation rule instance
     */
    public function __construct()
    {
        $this->useAthenaeumTranslations();
    }

    /**
     * @inheritDoc
     */
    public function passes($attribute, $value)
    {
        $this->setAttribute($attribute);

        // Ensure that value is string or numeric
        if (!is_string($value) && !is_numeric($value)) {
            return false;
        }

        // This rule is very similar to the "alpha dash" rule, yet with
        // a single addition: dot (period) is also allowed.
        return preg_match('/^[\pL\pM\pN._-]+$/u', $value) > 0;
    }

    /**
     * @inheritDoc
     */
    public function message()
    {
        return $this->trans('alpha_dash_dot', [
            'attribute' => $this->getAttribute()
        ]);
    }
}
