<?php

namespace Aedart\Support\Helpers\View;

use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\View;

/**
 * View Factory Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\View\ViewFactoryAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\View
 */
trait ViewFactoryTrait
{
    /**
     * View Factory instance
     *
     * @var Factory|null
     */
    protected ?Factory $viewFactory = null;

    /**
     * Set view factory
     *
     * @param Factory|null $factory View Factory instance
     *
     * @return self
     */
    public function setViewFactory(?Factory $factory)
    {
        $this->viewFactory = $factory;

        return $this;
    }

    /**
     * Get view factory
     *
     * If no view factory has been set, this method will
     * set and return a default view factory, if any such
     * value is available
     *
     * @see getDefaultViewFactory()
     *
     * @return Factory|null view factory or null if none view factory has been set
     */
    public function getViewFactory(): ?Factory
    {
        if (!$this->hasViewFactory()) {
            $this->setViewFactory($this->getDefaultViewFactory());
        }
        return $this->viewFactory;
    }

    /**
     * Check if view factory has been set
     *
     * @return bool True if view factory has been set, false if not
     */
    public function hasViewFactory(): bool
    {
        return isset($this->viewFactory);
    }

    /**
     * Get a default view factory value, if any is available
     *
     * @return Factory|null A default view factory value or Null if no default value is available
     */
    public function getDefaultViewFactory(): ?Factory
    {
        return View::getFacadeRoot();
    }
}
