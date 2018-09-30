<?php

namespace Aedart\Support\Helpers\Session;

use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Session;

/**
 * Session Manager Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Session\SessionManagerAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Session
 */
trait SessionManagerTrait
{
    /**
     * Session Manager instance
     *
     * @var SessionManager|null
     */
    protected $sessionManager = null;

    /**
     * Set session manager
     *
     * @param SessionManager|null $manager Session Manager instance
     *
     * @return self
     */
    public function setSessionManager(?SessionManager $manager)
    {
        $this->sessionManager = $manager;

        return $this;
    }

    /**
     * Get session manager
     *
     * If no session manager has been set, this method will
     * set and return a default session manager, if any such
     * value is available
     *
     * @see getDefaultSessionManager()
     *
     * @return SessionManager|null session manager or null if none session manager has been set
     */
    public function getSessionManager(): ?SessionManager
    {
        if (!$this->hasSessionManager()) {
            $this->setSessionManager($this->getDefaultSessionManager());
        }
        return $this->sessionManager;
    }

    /**
     * Check if session manager has been set
     *
     * @return bool True if session manager has been set, false if not
     */
    public function hasSessionManager(): bool
    {
        return isset($this->sessionManager);
    }

    /**
     * Get a default session manager value, if any is available
     *
     * @return SessionManager|null A default session manager value or Null if no default value is available
     */
    public function getDefaultSessionManager(): ?SessionManager
    {
        return Session::getFacadeRoot();
    }
}
