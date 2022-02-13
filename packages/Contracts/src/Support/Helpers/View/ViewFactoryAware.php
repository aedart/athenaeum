<?php

namespace Aedart\Contracts\Support\Helpers\View;

use Illuminate\Contracts\View\Factory;

/**
 * View Factory Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\View
 */
interface ViewFactoryAware
{
    /**
     * Set view factory
     *
     * @param Factory|null $factory View Factory instance
     *
     * @return self
     */
    public function setViewFactory(Factory|null $factory): static;

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
    public function getViewFactory(): Factory|null;

    /**
     * Check if view factory has been set
     *
     * @return bool True if view factory has been set, false if not
     */
    public function hasViewFactory(): bool;

    /**
     * Get a default view factory value, if any is available
     *
     * @return Factory|null A default view factory value or Null if no default value is available
     */
    public function getDefaultViewFactory(): Factory|null;
}
