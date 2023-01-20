<?php

namespace Aedart\Validation\Rules;

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
class SemanticVersion extends BaseRule
{
    /**
     * Regex pattern for matching Semantic Version string
     *
     * This is the official regex which is found on semver.org
     *
     * @see https://semver.org/
     */
    protected const REGEX_PATTERN = '/^(?P<major>0|[1-9]\d*)\.(?P<minor>0|[1-9]\d*)\.(?P<patch>0|[1-9]\d*)(?:-(?P<prerelease>(?:0|[1-9]\d*|\d*[a-zA-Z-][0-9a-zA-Z-]*)(?:\.(?:0|[1-9]\d*|\d*[a-zA-Z-][0-9a-zA-Z-]*))*))?(?:\+(?P<buildmetadata>[0-9a-zA-Z-]+(?:\.[0-9a-zA-Z-]+)*))?$/';

    /**
     * @inheritDoc
     */
    public function passes($attribute, $value)
    {
        $this->attribute = $attribute;

        if (!preg_match(static::REGEX_PATTERN, $value)) {
            return false;
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function message()
    {
        return $this->trans('sem_version', [
            'attribute' => $this->attribute
        ]);
    }
}
