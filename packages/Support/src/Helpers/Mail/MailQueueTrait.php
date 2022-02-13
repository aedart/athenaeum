<?php

namespace Aedart\Support\Helpers\Mail;

use Illuminate\Contracts\Mail\MailQueue;
use Illuminate\Support\Facades\Mail;

/**
 * Mail Queue Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Mail\MailQueueAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Mail
 */
trait MailQueueTrait
{
    /**
     * Mail Queue instance
     *
     * @var MailQueue|null
     */
    protected MailQueue|null $mailQueue = null;

    /**
     * Set mail queue
     *
     * @param MailQueue|null $queue Mail Queue instance
     *
     * @return self
     */
    public function setMailQueue(MailQueue|null $queue): static
    {
        $this->mailQueue = $queue;

        return $this;
    }

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
    public function getMailQueue(): MailQueue|null
    {
        if (!$this->hasMailQueue()) {
            $this->setMailQueue($this->getDefaultMailQueue());
        }
        return $this->mailQueue;
    }

    /**
     * Check if mail queue has been set
     *
     * @return bool True if mail queue has been set, false if not
     */
    public function hasMailQueue(): bool
    {
        return isset($this->mailQueue);
    }

    /**
     * Get a default mail queue value, if any is available
     *
     * @return MailQueue|null A default mail queue value or Null if no default value is available
     */
    public function getDefaultMailQueue(): MailQueue|null
    {
        /** @var \Illuminate\Contracts\Mail\Factory $manager */
        $manager = Mail::getFacadeRoot();
        if (isset($manager)) {
            return $manager->mailer();
        }

        return null;
    }
}
