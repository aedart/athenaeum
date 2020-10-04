<?php


namespace Aedart\Tests\Helpers\Dummies\Container;

/**
 * Component With Dependency
 *
 * FOR TESTING ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Container
 */
class ComponentWithDependency extends BaseComponent
{
    /**
     * Dependency
     *
     * @var SimpleComponent
     */
    public SimpleComponent $dependency;

    /**
     * ComponentWithDependencies constructor.
     *
     * @param  SimpleComponent  $component
     */
    public function __construct(SimpleComponent $component)
    {
        $this->dependency = $component;
    }
}
