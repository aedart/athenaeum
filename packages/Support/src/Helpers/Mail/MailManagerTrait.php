<?php

namespace Aedart\Support\Helpers\Mail;

use Illuminate\Contracts\Mail\Factory;
use Illuminate\Support\Facades\Mail;

/**
 * Mail Manager Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Mail\MailManagerAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Mail
 */
trait MailManagerTrait
{
    /**
     * Mail Manager Instance
     *
     * @var Factory|null
     */
    protected Factory|null $mailManager = null;

    /**
     * Set mail manager
     *
     * @param Factory|null $manager Mail Manager Instance
     *
     * @return self
     */
    public function setMailManager(Factory|null $manager): static
    {
        $this->mailManager = $manager;

        return $this;
    }

    /**
     * Get mail manager
     *
     * If no mail manager has been set, this method will
     * set and return a default mail manager, if any such
     * value is available
     *
     * @return Factory|null mail manager or null if none mail manager has been set
     */
    public function getMailManager(): Factory|null
    {
        if (!$this->hasMailManager()) {
            $this->setMailManager($this->getDefaultMailManager());
        }
        return $this->mailManager;
    }

    /**
     * Check if mail manager has been set
     *
     * @return bool True if mail manager has been set, false if not
     */
    public function hasMailManager(): bool
    {
        return isset($this->mailManager);
    }

    /**
     * Get a default mail manager value, if any is available
     *
     * @return Factory|null A default mail manager value or Null if no default value is available
     */
    public function getDefaultMailManager(): Factory|null
    {
        return Mail::getFacadeRoot();
    }
}
