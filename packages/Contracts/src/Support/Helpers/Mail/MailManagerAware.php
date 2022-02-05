<?php

namespace Aedart\Contracts\Support\Helpers\Mail;

use Illuminate\Contracts\Mail\Factory;

/**
 * Mail Manager Aware
 *
 * @see \Illuminate\Contracts\Mail\Factory
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Mail
 */
interface MailManagerAware
{
    /**
     * Set mail manager
     *
     * @param Factory|null $manager Mail Manager Instance
     *
     * @return self
     */
    public function setMailManager(Factory|null $manager): static;

    /**
     * Get mail manager
     *
     * If no mail manager has been set, this method will
     * set and return a default mail manager, if any such
     * value is available
     *
     * @return Factory|null mail manager or null if none mail manager has been set
     */
    public function getMailManager(): Factory|null;

    /**
     * Check if mail manager has been set
     *
     * @return bool True if mail manager has been set, false if not
     */
    public function hasMailManager(): bool;

    /**
     * Get a default mail manager value, if any is available
     *
     * @return Factory|null A default mail manager value or Null if no default value is available
     */
    public function getDefaultMailManager(): Factory|null;
}
