<?php

namespace Aedart\Tests\Integration\Streams;

use Aedart\Streams\Stream;
use Aedart\Tests\TestCases\Streams\StreamTestCase;

/**
 * F0_WhenAndUnlessTest
 *
 * @group streams
 * @group streams-f0
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams
 */
class F0_WhenAndUnlessTest extends StreamTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function appliesCallbackWhenTrue()
    {
        $stream = new Stream();

        $applied = false;
        $stream->when(true, function () use (&$applied) {
            $applied = true;
        });

        $this->assertTrue($applied);
    }

    /**
     * @test
     *
     * @return void
     */
    public function appliesOtherwiseCallbackWhenFalse()
    {
        $stream = new Stream();

        $applied = false;
        $stream->when(false, fn () => false, function () use (&$applied) {
            $applied = true;
        });

        $this->assertTrue($applied);
    }

    /**
     * @test
     *
     * @return void
     */
    public function resolveCallableResultForWhen()
    {
        $stream = new Stream();

        $applied = false;
        $stream->when(fn () => true, function () use (&$applied) {
            $applied = true;
        });

        $this->assertTrue($applied);
    }

    /**
     * @test
     *
     * @return void
     */
    public function appliesCallbackUnlessFalse()
    {
        $stream = new Stream();

        $applied = false;
        $stream->unless(false, function () use (&$applied) {
            $applied = true;
        });

        $this->assertTrue($applied);
    }

    /**
     * @test
     *
     * @return void
     */
    public function appliesOtherwiseCallbackUnlessFalse()
    {
        $stream = new Stream();

        $applied = false;
        $stream->unless(true, fn () => false, function () use (&$applied) {
            $applied = true;
        });

        $this->assertTrue($applied);
    }

    /**
     * @test
     *
     * @return void
     */
    public function resolveCallableResultForUnless()
    {
        $stream = new Stream();

        $applied = false;
        $stream->unless(fn () => false, function () use (&$applied) {
            $applied = true;
        });

        $this->assertTrue($applied);
    }
}
