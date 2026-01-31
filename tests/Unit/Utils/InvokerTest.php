<?php

namespace Aedart\Tests\Unit\Utils;

use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Helpers\Invoker;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;
use RuntimeException;

/**
 * InvokerTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Utils
 */
#[Group(
    'utils',
    'invoker',
)]
class InvokerTest extends UnitTestCase
{
    /**
     * @throws \Throwable
     */
    #[Test]
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
     * @throws \Throwable
     */
    #[Test]
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
     * @throws \Throwable
     */
    #[Test]
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
     * @throws \Throwable
     */
    #[Test]
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
