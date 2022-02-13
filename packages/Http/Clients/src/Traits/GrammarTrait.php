<?php

namespace Aedart\Http\Clients\Traits;

use Aedart\Contracts\Http\Clients\Requests\Query\Grammar;

/**
 * Http Query Grammar Trait
 *
 * @see \Aedart\Contracts\Http\Clients\Requests\Query\Grammars\GrammarAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Traits
 */
trait GrammarTrait
{
    /**
     * Http Query Grammar instance
     *
     * @var Grammar|null
     */
    protected Grammar|null $grammar = null;

    /**
     * Set grammar
     *
     * @param Grammar|null $grammar Http Query Grammar instance
     *
     * @return self
     */
    public function setGrammar(Grammar|null $grammar): static
    {
        $this->grammar = $grammar;

        return $this;
    }

    /**
     * Get grammar
     *
     * If no grammar has been set, this method will
     * set and return a default grammar, if any such
     * value is available
     *
     * @return Grammar|null grammar or null if none grammar has been set
     */
    public function getGrammar(): Grammar|null
    {
        if (!$this->hasGrammar()) {
            $this->setGrammar($this->getDefaultGrammar());
        }
        return $this->grammar;
    }

    /**
     * Check if grammar has been set
     *
     * @return bool True if grammar has been set, false if not
     */
    public function hasGrammar(): bool
    {
        return isset($this->grammar);
    }

    /**
     * Get a default grammar value, if any is available
     *
     * @return Grammar|null A default grammar value or Null if no default value is available
     */
    public function getDefaultGrammar(): Grammar|null
    {
        return null;
    }
}
