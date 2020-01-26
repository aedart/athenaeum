<?php

namespace Aedart\Console\Traits;

use Aedart\Contracts\Core\Application;
use Aedart\Support\Facades\IoCFacade;

/**
 * Core Application Trait
 *
 * @see \Aedart\Contracts\Console\CoreApplicationAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Console\Traits
 */
trait CoreApplicationTrait
{
    /**
     * Athenaeum Core Application instance
     *
     * @var Application|null
     */
    protected ?Application $coreApplication = null;

    /**
     * Set core application
     *
     * @param Application|null $core Athenaeum Core Application instance
     *
     * @return self
     */
    public function setCoreApplication(?Application $core)
    {
        $this->coreApplication = $core;

        return $this;
    }

    /**
     * Get core application
     *
     * If no core application has been set, this method will
     * set and return a default core application, if any such
     * value is available
     *
     * @return Application|null core application or null if none core application has been set
     */
    public function getCoreApplication(): ?Application
    {
        if (!$this->hasCoreApplication()) {
            $this->setCoreApplication($this->getDefaultCoreApplication());
        }
        return $this->coreApplication;
    }

    /**
     * Check if core application has been set
     *
     * @return bool True if core application has been set, false if not
     */
    public function hasCoreApplication(): bool
    {
        return isset($this->coreApplication);
    }

    /**
     * Get a default core application value, if any is available
     *
     * @return Application|null A default core application value or Null if no default value is available
     */
    public function getDefaultCoreApplication(): ?Application
    {
        return IoCFacade::tryMake(Application::class);
    }
}
