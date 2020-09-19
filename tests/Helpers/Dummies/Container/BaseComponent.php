<?php


namespace Aedart\Tests\Helpers\Dummies\Container;

/**
 * Base Component
 *
 * FOR TESTING ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Container
 */
abstract class BaseComponent
{
    /**
     * State whether or not a callback has
     * been applied.
     *
     * @var bool
     */
    public bool $callbackApplied = false;
}
