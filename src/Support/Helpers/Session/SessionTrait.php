<?php

namespace Aedart\Support\Helpers\Session;

use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Session as SessionFacade;

/**
 * Session Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Session\SessionAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Session
 */
trait SessionTrait
{
    /**
     * Session instance
     *
     * @var Session|null
     */
    protected $session = null;

    /**
     * Set session
     *
     * @param Session|null $session Session instance
     *
     * @return self
     */
    public function setSession(?Session $session)
    {
        $this->session = $session;

        return $this;
    }

    /**
     * Get session
     *
     * If no session has been set, this method will
     * set and return a default session, if any such
     * value is available
     *
     * @see getDefaultSession()
     *
     * @return Session|null session or null if none session has been set
     */
    public function getSession(): ?Session
    {
        if (!$this->hasSession()) {
            $this->setSession($this->getDefaultSession());
        }
        return $this->session;
    }

    /**
     * Check if session has been set
     *
     * @return bool True if session has been set, false if not
     */
    public function hasSession(): bool
    {
        return isset($this->session);
    }

    /**
     * Get a default session value, if any is available
     *
     * @return Session|null A default session value or Null if no default value is available
     */
    public function getDefaultSession(): ?Session
    {
        $manager = SessionFacade::getFacadeRoot();
        if (isset($manager)) {
            return $manager->driver();
        }
        return $manager;
    }
}
