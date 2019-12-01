<?php

namespace Aedart\Testing\Helpers;

use Codeception\Util\Debug;

/**
 * Console Debugger
 *
 * <br />
 *
 * Debugging utilities for console, during tests
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Testing\Helpers
 */
class ConsoleDebugger
{
    /**
     * Output debug message
     *
     * @param mixed ...$message
     */
    public static function output(...$message)
    {
        if(class_exists(Debug::class)){

            $message = array_map(function($msg){
                if(is_string($msg)){
                    return $msg;
                }

                return print_r($msg, true);
            }, $message);

            Debug::debug(PHP_EOL . implode(', ', $message));
            return;
        }

        // get args
        $args = $_SERVER['argv'];
        if (in_array('--debug', $args) || in_array('-vvv', $args) || in_array('--verbose', $args)) {
            fwrite(STDERR, PHP_EOL . print_r($message, true));
        }
    }
}
