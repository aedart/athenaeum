<?php

namespace Aedart\Contracts\Antivirus;

/**
 * Antivirus Manager Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Antivirus
 */
interface AntivirusManagerAware
{
    /**
     * Set antivirus manager
     *
     * @param Manager|null $manager Antivirus Manager instance
     *
     * @return self
     */
    public function setAntivirusManager(Manager|null $manager): static;

    /**
     * Get antivirus manager
     *
     * If no antivirus manager has been set, this method will
     * set and return a default antivirus manager, if any such
     * value is available
     *
     * @return Manager|null antivirus manager or null if none antivirus manager has been set
     */
    public function getAntivirusManager(): Manager|null;

    /**
     * Check if antivirus manager has been set
     *
     * @return bool True if antivirus manager has been set, false if not
     */
    public function hasAntivirusManager(): bool;

    /**
     * Get a default antivirus manager value, if any is available
     *
     * @return Manager|null A default antivirus manager value or Null if no default value is available
     */
    public function getDefaultAntivirusManager(): Manager|null;
}