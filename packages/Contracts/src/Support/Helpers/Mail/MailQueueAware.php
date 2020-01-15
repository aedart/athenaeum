<?php

namespace Aedart\Contracts\Support\Helpers\Mail;

use Illuminate\Contracts\Mail\MailQueue;

/**
 * Mail Queue Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Mail
 */
interface MailQueueAware
{
    /**
     * Set mail queue
     *
     * @param MailQueue|null $queue Mail Queue instance
     *
     * @return self
     */
    public function setMailQueue(?MailQueue $queue);

    /**
     * Get mail queue
     *
     * If no mail queue has been set, this method will
     * set and return a default mail queue, if any such
     * value is available
     *
     * @see getDefaultMailQueue()
     *
     * @return MailQueue|null mail queue or null if none mail queue has been set
     */
    public function getMailQueue(): ?MailQueue;

    /**
     * Check if mail queue has been set
     *
     * @return bool True if mail queue has been set, false if not
     */
    public function hasMailQueue(): bool;

    /**
     * Get a default mail queue value, if any is available
     *
     * @return MailQueue|null A default mail queue value or Null if no default value is available
     */
    public function getDefaultMailQueue(): ?MailQueue;
}
