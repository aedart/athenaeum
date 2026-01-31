<?php

namespace Aedart\Tests\Integration\Container;

use Aedart\Container\ListResolver;
use Aedart\Contracts\Container\ListResolver as ListResolverInterface;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\IntegrationTestCase;
use Aedart\Tests\Helpers\Dummies\Container\ComponentWithArgsAndDependencies;
use Aedart\Tests\Helpers\Dummies\Container\ComponentWithArguments;
use Aedart\Tests\Helpers\Dummies\Container\ComponentWithDependency;
use Aedart\Tests\Helpers\Dummies\Container\SimpleComponent;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * ListResolverTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Container
 */
#[Group(
    'ioc',
    'container',
    'list-resolver',
)]
class ListResolverTest extends IntegrationTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Creates new List Resolver instance
     *
     * @return ListResolverInterface
     */
    public function makeResolver(): ListResolverInterface
    {
        return new ListResolver($this->ioc);
    }

    /**
     * Returns a list of dependencies to be resolved
     *
     * @return array
     */
    public function makeList(): array
    {
        return [
            SimpleComponent::class,
            ComponentWithDependency::class,
            ComponentWithArguments::class => [
                'a' => true,
                'b' => 42,
                'options' => [ 'a', 'b', 'c' ],
            ],
            ComponentWithArgsAndDependencies::class => [
                'options' => [ 'sweet' => true ]
            ],
        ];
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    #[Test]
    public function canResolveListOfDependencies()
    {
        $list = $this->makeList();

        $resolved = $this->makeResolver()->make($list);

        // -------------------------------------------------------- //
        ConsoleDebugger::output($resolved);

        $this->assertCount(count($list), $resolved, 'Incorrect amount of instance resolved');

        /** @var SimpleComponent $a */
        $a = $resolved[0];
        $this->assertInstanceOf(SimpleComponent::class, $a, 'a incorrect resolved');

        /** @var ComponentWithDependency $b */
        $b = $resolved[1];
        $this->assertInstanceOf(ComponentWithDependency::class, $b, 'b incorrect resolved');
        $this->assertInstanceOf(SimpleComponent::class, $b->dependency, 'b has incorrect nested dependency');

        /** @var ComponentWithArguments $c */
        $c = $resolved[2];
        $this->assertInstanceOf(ComponentWithArguments::class, $c, 'c incorrect resolved');
        $this->assertTrue($c->a, 'arg. a incorrect');
        $this->assertSame(42, $c->b, 'arg. b incorrect');
        $this->assertSame(['a', 'b', 'c'], $c->options, 'arg. c incorrect');
        $this->assertSame('ok', $c->optional, 'optional arg. incorrect for c');

        /** @var ComponentWithArgsAndDependencies $d */
        $d = $resolved[3];
        $this->assertInstanceOf(ComponentWithArgsAndDependencies::class, $d, 'd incorrect resolved');
        $this->assertInstanceOf(ComponentWithDependency::class, $d->dependency, 'd has incorrect nested dependency');
        $this->assertInstanceOf(SimpleComponent::class, $d->dependency->dependency, 'd has incorrect deep nested dependency');
        $this->assertSame(['sweet' => true, ], $d->options, 'optional arg. incorrect for d');
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    #[Test]
    public function appliesCallback()
    {
        $list = $this->makeList();

        $resolved = $this->makeResolver()
            ->with(function ($instance) {
                $instance->callbackApplied = true;

                return $instance;
            })
            ->make($list);

        foreach ($resolved as $key => $instance) {
            $this->assertTrue($instance->callbackApplied, "Callback not applied for instance no. $key");
        }
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    #[Test]
    public function skipsResolveIfAlreadyInstantiated()
    {
        // In this example the list consists of class paths and
        // a single created instance. While this might not be a
        // nice data structure, it could happen that someone
        // appends to a list, without realising that an instance
        // has already been created.
        $list = [
            SimpleComponent::class,
            SimpleComponent::class,
            new SimpleComponent()
        ];

        $resolved = $this->makeResolver()
            ->with(function ($instance) {
                $instance->callbackApplied = true;

                return $instance;
            })
            ->make($list);

        // We expect that the created instance skips the Service Container
        // `make()` call and is just passed on to the callback. Thus, all
        // instances should be processed.
        foreach ($resolved as $key => $instance) {
            $this->assertTrue($instance->callbackApplied, "Callback not applied for instance no. $key");
        }
    }
}
