<?php

namespace Aedart\Validation\Rules;

use Aedart\Contracts\Support\Helpers\Translation\TranslatorAware;
use Aedart\Support\Helpers\Translation\TranslatorTrait;
use Illuminate\Contracts\Validation\Rule;

/**
 * Base Validation Rule
 *
 * Abstraction that offers common utility methods for
 * validation rules.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Acl\Rules
 */
abstract class BaseRule implements
    Rule,
    TranslatorAware
{
    use TranslatorTrait;

    /**
     * Name of the attribute in question
     *
     * @var string
     */
    protected string $attribute;

    /**
     * Get the translation for a given key.
     *
     * Method ensures to vendor-prefix the given translation key, so that
     * the package's translations are used.
     *
     * @param string $key
     * @param string[] $replace [optional]
     * @param string|null $locale [optional]
     *
     * @return string
     */
    protected function trans(string $key, array $replace = [], string|null $locale = null): string
    {
        // Vendor prefix key
        $key = "athenaeum-validation::messages.{$key}";

        return $this->getTranslator()->get($key, $replace, $locale);
    }
}
