<?php

namespace Aedart\Contracts\Http\Clients\Requests\Query\Grammars;

/**
 * Http Query Grammar Manager Aware
 *
 * @see \Aedart\Contracts\Http\Clients\Requests\Query\Grammars\Manager
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Clients\Requests\Query\Grammars
 */
interface GrammarManagerAware
{
    /**
     * Set grammar manager
     *
     * @param Manager|null $manager Http Query Grammar Manager instance
     *
     * @return self
     */
    public function setGrammarManager(?Manager $manager);

    /**
     * Get grammar manager
     *
     * If no grammar manager has been set, this method will
     * set and return a default grammar manager, if any such
     * value is available
     *
     * @return Manager|null grammar manager or null if none grammar manager has been set
     */
    public function getGrammarManager(): ?Manager;

    /**
     * Check if grammar manager has been set
     *
     * @return bool True if grammar manager has been set, false if not
     */
    public function hasGrammarManager(): bool;

    /**
     * Get a default grammar manager value, if any is available
     *
     * @return Manager|null A default grammar manager value or Null if no default value is available
     */
    public function getDefaultGrammarManager(): ?Manager;
}
