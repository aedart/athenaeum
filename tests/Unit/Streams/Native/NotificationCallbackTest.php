<?php

namespace Aedart\Tests\Unit\Streams\Native;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * NotificationCallbackTest
 *
 * @group streams
 * @group streams-notification
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Streams
 */
#[Group(
    'streams',
    'streams-notification',
)]
class NotificationCallbackTest extends UnitTestCase
{
    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function notifiesOnStreamChange()
    {
        $hasInvoked = false;
        $callback = function () use (&$hasInvoked) {
            $args = func_get_args();

            ConsoleDebugger::output($args);

            $hasInvoked = true;
        };

        $context = stream_context_create();
        stream_context_set_params($context, [ 'notification' => $callback ]);

        // This does NOT work...
        // $stream = fopen('php://memory', 'w+', false, $context);
        // fwrite($stream, $this->getFaker()->realText(50));

        // NOTE: It appears that notification callbacks are ONLY supported by
        // http(s):// and ftp(s):// stream wrappers!
        $stream = fopen('https://google.com', 'r', false, $context);
        fclose($stream);

        $this->assertTrue($hasInvoked);
    }
}
