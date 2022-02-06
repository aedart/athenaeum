<?php

namespace Aedart\Contracts\Support\Helpers\Mail;

use Illuminate\Contracts\Mail\Mailer;

/**
 * Mailer Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Mail
 */
interface MailerAware
{
    /**
     * Set mailer
     *
     * @param Mailer|null $mailer Mailer instance
     *
     * @return self
     */
    public function setMailer(Mailer|null $mailer): static;

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
    public function getMailer(): Mailer|null;

    /**
     * Check if mailer has been set
     *
     * @return bool True if mailer has been set, false if not
     */
    public function hasMailer(): bool;

    /**
     * Get a default mailer value, if any is available
     *
     * @return Mailer|null A default mailer value or Null if no default value is available
     */
    public function getDefaultMailer(): Mailer|null;
}
