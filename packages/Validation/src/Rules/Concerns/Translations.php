<?php

namespace Aedart\Validation\Rules\Concerns;

use Aedart\Support\Helpers\Translation\TranslatorTrait;
use Aedart\Utils\Str;

/**
 * Concerns Translations
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Validation\Rules\Concerns
 */
trait Translations
{
    use TranslatorTrait;

    /**
     * Prefix for translations keys
     *
     * @var string|null
     */
    protected string|null $translationKeyPrefix = null;

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
    public function trans(string $key, array $replace = [], string|null $locale = null): string
    {
        $prefix = $this->getTranslationKeyPrefix() ?? '';
        if (!empty($prefix) && !Str::endsWith($prefix, '.')) {
            $prefix .= '.';
        }

        $key = "{$prefix}{$key}";

        return $this->getTranslator()->get($key, $replace, $locale);
    }

    /**
     * Set translation key prefix
     *
     * @param string|null $prefix [optional] E.g. vendor prefix
     *
     * @return self
     */
    public function setTranslationKeyPrefix(string|null $prefix = null): static
    {
        $this->translationKeyPrefix = $prefix;

        return $this;
    }

    /**
     * Get translation key prefix
     *
     * @return string|null
     */
    public function getTranslationKeyPrefix(): string|null
    {
        return $this->translationKeyPrefix;
    }
}
