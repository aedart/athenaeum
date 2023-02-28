<?php

namespace Aedart\Validation\Rules\Concerns;

/**
 * @deprecated Since 7.4 - Will be removed in next major version
 *
 * Concerns Athenaeum Validation Rule
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Validation\Rules\Concerns
 */
trait AthenaeumRule
{
    /**
     * Configures validation rule's translation prefix (vendor prefix)
     * to use that of Athenaeum.
     *
     * @return static
     */
    protected function useAthenaeumTranslations(): static
    {
        return $this->setTranslationKeyPrefix('athenaeum-validation::messages');
    }
}
