<?php

namespace Aedart\Contracts\Support\Helpers\Session;

use Illuminate\Session\SessionManager;

/**
 * Session Manager Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Session
 */
interface SessionManagerAware
{
    /**
     * Set session manager
     *
     * @param SessionManager|null $manager Session Manager instance
     *
     * @return self
     */
    public function setSessionManager(?SessionManager $manager);

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
    public function getSessionManager(): ?SessionManager;

    /**
     * Check if session manager has been set
     *
     * @return bool True if session manager has been set, false if not
     */
    public function hasSessionManager(): bool;

    /**
     * Get a default session manager value, if any is available
     *
     * @return SessionManager|null A default session manager value or Null if no default value is available
     */
    public function getDefaultSessionManager(): ?SessionManager;
}
