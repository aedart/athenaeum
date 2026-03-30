<?php

namespace Aedart\Tests\Integration\Streams;

use Aedart\Streams\Stream;
use Aedart\Tests\TestCases\Streams\StreamTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * F0_WhenAndUnlessTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams
 */
#[Group(
    'streams',
    'stream-f0',
)]
class F0_WhenAndUnlessTest extends StreamTestCase
{
    /**
     * @return void
     */
    #[Test]
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
     * @return void
     */
    #[Test]
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
     * @return void
     */
    #[Test]
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
     * @return void
     */
    #[Test]
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
     * @return void
     */
    #[Test]
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
     * @return void
     */
    #[Test]
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
