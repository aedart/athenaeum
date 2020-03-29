<?php

namespace Aedart\Http\Clients\Traits;

use Aedart\Contracts\Http\Clients\Requests\Query\Grammars\Manager;
use Aedart\Support\Facades\IoCFacade;

/**
 * Http Query Grammar Manager Trait
 *
 * @see \Aedart\Contracts\Http\Clients\Requests\Query\Grammars\GrammarManagerAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Traits
 */
trait GrammarManagerTrait
{
    /**
     * Http Query Grammar Manager instance
     *
     * @var Manager|null
     */
    protected ?Manager $grammarManager = null;

    /**
     * Set grammar manager
     *
     * @param Manager|null $manager Http Query Grammar Manager instance
     *
     * @return self
     */
    public function setGrammarManager(?Manager $manager)
    {
        $this->grammarManager = $manager;

        return $this;
    }

    /**
     * Get grammar manager
     *
     * If no grammar manager has been set, this method will
     * set and return a default grammar manager, if any such
     * value is available
     *
     * @return Manager|null grammar manager or null if none grammar manager has been set
     */
    public function getGrammarManager(): ?Manager
    {
        if (!$this->hasGrammarManager()) {
            $this->setGrammarManager($this->getDefaultGrammarManager());
        }
        return $this->grammarManager;
    }

    /**
     * Check if grammar manager has been set
     *
     * @return bool True if grammar manager has been set, false if not
     */
    public function hasGrammarManager(): bool
    {
        return isset($this->grammarManager);
    }

    /**
     * Get a default grammar manager value, if any is available
     *
     * @return Manager|null A default grammar manager value or Null if no default value is available
     */
    public function getDefaultGrammarManager(): ?Manager
    {
        return IoCFacade::tryMake(Manager::class);
    }
}
