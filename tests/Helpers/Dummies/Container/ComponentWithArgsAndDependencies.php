<?php


namespace Aedart\Tests\Helpers\Dummies\Container;

/**
 * Component With Args And Dependencies
 *
 * FOR TESTING ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Container
 */
class ComponentWithArgsAndDependencies extends BaseComponent
{
    public ComponentWithDependency $dependency;
    public array $options;

    /**
     * ComponentWithArgsAndDependencies constructor.
     *
     * @param  ComponentWithDependency  $component
     * @param  array  $options
     */
    public function __construct(ComponentWithDependency $component, array $options)
    {
        $this->dependency = $component;
        $this->options = $options;
    }
}
