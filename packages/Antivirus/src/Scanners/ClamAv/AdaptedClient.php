<?php

namespace Aedart\Antivirus\Scanners\ClamAv;

use Throwable;
use Xenolope\Quahog\Client as BaseClient;
use Xenolope\Quahog\Exception\ConnectionException;

/**
 * Adapted ClamAv Client
 *
 * @see BaseClient
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Antivirus\Scanners\ClamAv
 */
class AdaptedClient extends BaseClient
{
    /**
     * State whether client has a session
     * started or not.
     *
     * (Base client sadly has declared "_inSession" for
     * private, meaning that this is a duplicate!)
     *
     * @var bool
     */
    protected bool $hasSession = false;

    /**
     * Destructor
     */
    public function __destruct()
    {
        if (!$this->hasSession()) {
            return;
        }

        try {
            $this->disconnect();
        } catch (Throwable $e) {
            // Unable to do anything at this point. Throwing exceptions in
            // a destructor will just cause a fatal error...
        }
    }

    /**
     * Start a session
     *
     * @return void
     *
     * @throws ConnectionException If a session has already been started
     */
    public function startSession()
    {
        if ($this->hasSession()) {
            throw new ConnectionException('A session has already been started');
        }

        $this->hasSession = true;

        parent::startSession();
    }

    /**
     * End session
     *
     * @return void
     */
    public function endSession()
    {
        // Do nothing, if no session started
        if (!$this->hasSession()) {
            return;
        }

        parent::endSession();

        $this->hasSession = false;
    }

    /**
     * Determine if client has started a session
     *
     * @return bool
     */
    public function hasSession(): bool
    {
        return $this->hasSession;
    }
}
