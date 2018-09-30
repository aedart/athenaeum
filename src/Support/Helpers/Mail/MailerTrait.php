<?php

namespace Aedart\Support\Helpers\Mail;

use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Support\Facades\Mail;

/**
 * Mailer Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Mail\MailerAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Mail
 */
trait MailerTrait
{
    /**
     * Mailer instance
     *
     * @var Mailer|null
     */
    protected $mailer = null;

    /**
     * Set mailer
     *
     * @param Mailer|null $mailer Mailer instance
     *
     * @return self
     */
    public function setMailer(?Mailer $mailer)
    {
        $this->mailer = $mailer;

        return $this;
    }

    /**
     * Get mailer
     *
     * If no mailer has been set, this method will
     * set and return a default mailer, if any such
     * value is available
     *
     * @see getDefaultMailer()
     *
     * @return Mailer|null mailer or null if none mailer has been set
     */
    public function getMailer(): ?Mailer
    {
        if (!$this->hasMailer()) {
            $this->setMailer($this->getDefaultMailer());
        }
        return $this->mailer;
    }

    /**
     * Check if mailer has been set
     *
     * @return bool True if mailer has been set, false if not
     */
    public function hasMailer(): bool
    {
        return isset($this->mailer);
    }

    /**
     * Get a default mailer value, if any is available
     *
     * @return Mailer|null A default mailer value or Null if no default value is available
     */
    public function getDefaultMailer(): ?Mailer
    {
        return Mail::getFacadeRoot();
    }
}
