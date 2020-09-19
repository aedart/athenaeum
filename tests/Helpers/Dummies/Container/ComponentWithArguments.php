<?php


namespace Aedart\Tests\Helpers\Dummies\Container;

/**
 * Component With Arguments
 *
 * FOR TESTING ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Container
 */
class ComponentWithArguments extends BaseComponent
{
    public bool $a;
    public int $b;
    public array $options;
    public string $optional;

    /**
     * ComponentWithArguments constructor.
     *
     * @param  bool  $a
     * @param  int  $b
     * @param  array  $options
     * @param  string  $optional  [optional]
     */
    public function __construct(
        bool $a,
        int $b,
        array $options,
        string $optional = 'ok'
    ) {
        $this->a = $a;
        $this->b = $b;
        $this->options = $options;
        $this->optional = $optional;
    }
}
