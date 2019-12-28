<?php

namespace Aedart\Contracts\Core;

/**
 * Application Aware
 *
 * @see \Aedart\Contracts\Core\Application
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Core
 */
interface ApplicationAware
{
    /**
     * Set application
     *
     * @param Application|null $application Application instance
     *
     * @return self
     */
    public function setApplication(?Application $application);

    /**
     * Get application
     *
     * If no application has been set, this method will
     * set and return a default application, if any such
     * value is available
     *
     * @return Application|null application or null if none application has been set
     */
    public function getApplication(): ?Application;

    /**
     * Check if application has been set
     *
     * @return bool True if application has been set, false if not
     */
    public function hasApplication(): bool;

    /**
     * Get a default application value, if any is available
     *
     * @return Application|null A default application value or Null if no default value is available
     */
    public function getDefaultApplication(): ?Application;
}
