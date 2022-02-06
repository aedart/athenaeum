<?php

namespace Aedart\Contracts\Console;

use Aedart\Contracts\Core\Application;

/**
 * Core Application Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Console
 */
interface CoreApplicationAware
{
    /**
     * Set core application
     *
     * @param Application|null $core Athenaeum Core Application instance
     *
     * @return self
     */
    public function setCoreApplication(Application|null $core): static;

    /**
     * Get core application
     *
     * If no core application has been set, this method will
     * set and return a default core application, if any such
     * value is available
     *
     * @return Application|null core application or null if none core application has been set
     */
    public function getCoreApplication(): Application|null;

    /**
     * Check if core application has been set
     *
     * @return bool True if core application has been set, false if not
     */
    public function hasCoreApplication(): bool;

    /**
     * Get a default core application value, if any is available
     *
     * @return Application|null A default core application value or Null if no default value is available
     */
    public function getDefaultCoreApplication(): Application|null;
}
