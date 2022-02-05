<?php

namespace Aedart\Contracts\Support\Helpers\View;

/**
 * Blade Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\View
 */
interface BladeAware
{
    /**
     * Set blade
     *
     * @param \Illuminate\View\Compilers\BladeCompiler|null $compiler Laravel Blade Compiler instance
     *
     * @return self
     */
    public function setBlade($compiler): static;

    /**
     * Get blade
     *
     * If no blade has been set, this method will
     * set and return a default blade, if any such
     * value is available
     *
     * @see getDefaultBlade()
     *
     * @return \Illuminate\View\Compilers\BladeCompiler|null blade or null if none blade has been set
     */
    public function getBlade();

    /**
     * Check if blade has been set
     *
     * @return bool True if blade has been set, false if not
     */
    public function hasBlade(): bool;

    /**
     * Get a default blade value, if any is available
     *
     * @return \Illuminate\View\Compilers\BladeCompiler|null A default blade value or Null if no default value is available
     */
    public function getDefaultBlade();
}
