<?php

namespace Aedart\Tests\Unit\Utils;

use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Helpers\Invoker;
use RuntimeException;

/**
 * InvokerTest
 *
 * @group util
 * @group invoker
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Utils
 */
class InvokerTest extends UnitTestCase
{
    /**
     * @test
     *
     * @throws \Throwable
     */
    public function invokesCallback()
    {
        $callback = function () {
            return true;
        };

        $result = Invoker::invoke($callback)
            ->call();

        $this->assertTrue($result);
    }

    /**
     * @test
     *
     * @throws \Throwable
     */
    public function callsFallbackWhenCallbackNotCallable()
    {
        $callback = []; // Invalid callback
        $fallback = function () {
            return true;
        };

        $result = Invoker::invoke($callback)
            ->fallback($fallback)
            ->call();

        $this->assertTrue($result);
    }

    /**
     * @test
     *
     * @throws \Throwable
     */
    public function failsWhenNotCallable()
    {
        $this->expectException(RuntimeException::class);

        $callback = []; // Invalid callback
        $fallback = []; // Invalid callback

        Invoker::invoke($callback)
            ->fallback($fallback)
            ->call();
    }

    /**
     * @test
     *
     * @throws \Throwable
     */
    public function callsCallbackWithArguments()
    {
        $callback = function ($a, $b, $c) {
            return [$a, $b, $c];
        };

        $result = Invoker::invoke($callback)
            ->with('a', 'b', 'c')
            ->call();

        $this->assertSame(['a', 'b', 'c'], $result);
    }
}
