<?php

namespace Aedart\Validation\Rules;

use Closure;

/**
 * Semantic Version
 *
 * Ensures given version identifier is according to Semantic Versioning 2.0
 *
 * @see https://semver.org/
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Validation\Rules
 */
class SemanticVersion extends BaseValidationRule
{
    /**
     * Regex pattern for matching Semantic Version string
     *
     * This is the official regex which is found on semver.org
     *
     * @see https://semver.org/
     */
    protected const string REGEX_PATTERN = '/^(?P<major>0|[1-9]\d*)\.(?P<minor>0|[1-9]\d*)\.(?P<patch>0|[1-9]\d*)(?:-(?P<prerelease>(?:0|[1-9]\d*|\d*[a-zA-Z-][0-9a-zA-Z-]*)(?:\.(?:0|[1-9]\d*|\d*[a-zA-Z-][0-9a-zA-Z-]*))*))?(?:\+(?P<buildmetadata>[0-9a-zA-Z-]+(?:\.[0-9a-zA-Z-]+)*))?$/';

    /**
     * @inheritDoc
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->isValid($value)) {
            $fail('athenaeum-validation::messages.sem_version')->translate([
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
        if (!preg_match(static::REGEX_PATTERN, $value)) {
            return false;
        }

        return true;
    }
}
