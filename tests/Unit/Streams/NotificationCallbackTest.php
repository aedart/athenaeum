<?php

namespace Aedart\Tests\Unit\Streams;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;

/**
 * NotificationCallbackTest
 *
 * @group streams
 * @group streams-notification
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Streams
 */
class NotificationCallbackTest extends UnitTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function notifiesOnStreamChange()
    {
        $hasInvoked = false;
        $callback = function() use(&$hasInvoked) {
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
        $stream = fopen('http://localhost', 'r', false, $context);
        fclose($stream);

        $this->assertTrue($hasInvoked);
    }
}
