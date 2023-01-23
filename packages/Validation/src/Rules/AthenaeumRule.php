<?php

namespace Aedart\Validation\Rules;

/**
 * Athenaeum Validation Rule
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Validation\Rules
 */
abstract class AthenaeumRule extends BaseRule
{
    /**
     * Creates a new validation rule instance
     */
    public function __construct()
    {
        $this->setTranslationKeyPrefix('athenaeum-validation::messages');
    }
}
