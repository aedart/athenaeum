<?php

namespace Aedart\Contracts\Http\Clients\Requests\Query\Grammars;

use Aedart\Contracts\Http\Clients\Requests\Query\Grammar;

/**
 * Http Query Grammar Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Clients\Requests\Query\Grammars
 */
interface GrammarAware
{
    /**
     * Set grammar
     *
     * @param Grammar|null $grammar Http Query Grammar instance
     *
     * @return self
     */
    public function setGrammar(Grammar|null $grammar): static;

    /**
     * Get grammar
     *
     * If no grammar has been set, this method will
     * set and return a default grammar, if any such
     * value is available
     *
     * @return Grammar|null grammar or null if none grammar has been set
     */
    public function getGrammar(): Grammar|null;

    /**
     * Check if grammar has been set
     *
     * @return bool True if grammar has been set, false if not
     */
    public function hasGrammar(): bool;

    /**
     * Get a default grammar value, if any is available
     *
     * @return Grammar|null A default grammar value or Null if no default value is available
     */
    public function getDefaultGrammar(): Grammar|null;
}
