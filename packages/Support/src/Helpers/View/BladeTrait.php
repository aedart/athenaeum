<?php

namespace Aedart\Support\Helpers\View;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\View\Compilers\BladeCompiler;

/**
 * Blade Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\View\BladeAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\View
 */
trait BladeTrait
{
    /**
     * Laravel Blade Compiler instance
     *
     * @var BladeCompiler|null
     */
    protected ?BladeCompiler $blade = null;

    /**
     * Set blade
     *
     * @param BladeCompiler|null $compiler Laravel Blade Compiler instance
     *
     * @return self
     */
    public function setBlade(?BladeCompiler $compiler)
    {
        $this->blade = $compiler;

        return $this;
    }

    /**
     * Get blade
     *
     * If no blade has been set, this method will
     * set and return a default blade, if any such
     * value is available
     *
     * @see getDefaultBlade()
     *
     * @return BladeCompiler|null blade or null if none blade has been set
     */
    public function getBlade(): ?BladeCompiler
    {
        if (!$this->hasBlade()) {
            $this->setBlade($this->getDefaultBlade());
        }
        return $this->blade;
    }

    /**
     * Check if blade has been set
     *
     * @return bool True if blade has been set, false if not
     */
    public function hasBlade(): bool
    {
        return isset($this->blade);
    }

    /**
     * Get a default blade value, if any is available
     *
     * @return BladeCompiler|null A default blade value or Null if no default value is available
     */
    public function getDefaultBlade(): ?BladeCompiler
    {
        $view = View::getFacadeRoot();
        if (isset($view)) {
            return Blade::getFacadeRoot();
        }
        return $view;
    }
}
