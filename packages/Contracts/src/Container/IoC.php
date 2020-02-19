<?php

namespace Aedart\Contracts\Container;

use Illuminate\Contracts\Container\Container;

/**
 * Inverse-of-Control (IoC) Service Container
 *
 * <br />
 *
 * Adapted version of Laravel IoC Service Container.
 *
 * @see \Illuminate\Contracts\Container\Container
 * @link https://en.wikipedia.org/wiki/Inversion_of_control
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Container
 */
interface IoC extends Container
{
    /**
     * Destroy the current IoC Service Container instance
     */
    public function destroy(): void;
}
