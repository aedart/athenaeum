<?php

namespace Aedart\Core\Traits;

use Aedart\Contracts\Core\Application;
use Aedart\Support\Facades\IoCFacade;

/**
 * Application Trait
 *
 * @see \Aedart\Contracts\Core\ApplicationAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Core\Traits
 */
trait ApplicationTrait
{
    /**
     * Application instance
     *
     * @var Application|null
     */
    protected ?Application $application = null;

    /**
     * Set application
     *
     * @param Application|null $application Application instance
     *
     * @return self
     */
    public function setApplication(?Application $application)
    {
        $this->application = $application;

        return $this;
    }

    /**
     * Get application
     *
     * If no application has been set, this method will
     * set and return a default application, if any such
     * value is available
     *
     * @return Application|null application or null if none application has been set
     */
    public function getApplication(): ?Application
    {
        if (!$this->hasApplication()) {
            $this->setApplication($this->getDefaultApplication());
        }
        return $this->application;
    }

    /**
     * Check if application has been set
     *
     * @return bool True if application has been set, false if not
     */
    public function hasApplication(): bool
    {
        return isset($this->application);
    }

    /**
     * Get a default application value, if any is available
     *
     * @return Application|null A default application value or Null if no default value is available
     */
    public function getDefaultApplication(): ?Application
    {
        return IoCFacade::tryMake(Application::class);
    }
}
