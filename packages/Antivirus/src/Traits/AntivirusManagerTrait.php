<?php

namespace Aedart\Antivirus\Traits;

use Aedart\Contracts\Antivirus\Manager;
use Aedart\Support\Facades\IoCFacade;

/**
 * Antivirus Manager Trait
 *
 * @see \Aedart\Contracts\Antivirus\AntivirusManagerAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Antivirus\Traits
 */
trait AntivirusManagerTrait
{
    /**
     * Antivirus Manager instance
     *
     * @var Manager|null
     */
    protected Manager|null $antivirusManager = null;

    /**
     * Set antivirus manager
     *
     * @param Manager|null $manager Antivirus Manager instance
     *
     * @return self
     */
    public function setAntivirusManager(Manager|null $manager): static
    {
        $this->antivirusManager = $manager;

        return $this;
    }

    /**
     * Get antivirus manager
     *
     * If no antivirus manager has been set, this method will
     * set and return a default antivirus manager, if any such
     * value is available
     *
     * @return Manager|null antivirus manager or null if none antivirus manager has been set
     */
    public function getAntivirusManager(): Manager|null
    {
        if (!$this->hasAntivirusManager()) {
            $this->setAntivirusManager($this->getDefaultAntivirusManager());
        }
        return $this->antivirusManager;
    }

    /**
     * Check if antivirus manager has been set
     *
     * @return bool True if antivirus manager has been set, false if not
     */
    public function hasAntivirusManager(): bool
    {
        return isset($this->antivirusManager);
    }

    /**
     * Get a default antivirus manager value, if any is available
     *
     * @return Manager|null A default antivirus manager value or Null if no default value is available
     */
    public function getDefaultAntivirusManager(): Manager|null
    {
        return IoCFacade::tryMake(Manager::class);
    }
}
