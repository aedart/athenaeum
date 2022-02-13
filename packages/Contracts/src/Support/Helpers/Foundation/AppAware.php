<?php

namespace Aedart\Contracts\Support\Helpers\Foundation;

use Illuminate\Contracts\Foundation\Application;

/**
 * App Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Foundation
 */
interface AppAware
{
    /**
     * Set app
     *
     * @param Application|null $application Laravel Application instance
     *
     * @return self
     */
    public function setApp(Application|null $application): static;

    /**
     * Get app
     *
     * If no app has been set, this method will
     * set and return a default app, if any such
     * value is available
     *
     * @see getDefaultApp()
     *
     * @return Application|null app or null if none app has been set
     */
    public function getApp(): Application|null;

    /**
     * Check if app has been set
     *
     * @return bool True if app has been set, false if not
     */
    public function hasApp(): bool;

    /**
     * Get a default app value, if any is available
     *
     * @return Application|null A default app value or Null if no default value is available
     */
    public function getDefaultApp(): Application|null;
}
