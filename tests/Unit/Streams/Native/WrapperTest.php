<?php

namespace Aedart\Tests\Unit\Streams\Native;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;

/**
 * WrapperTest
 *
 * @group streams
 * @group streams-wrapper
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Streams
 */
class WrapperTest extends UnitTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Define a stream wrapper ~ a decorator class
     *
     * @return object
     */
    public function defineDecorator(): object
    {
        return new class() {
            public const WRAPPER_NAME = 'decorator';

            /**
             * @var resource
             */
            protected $stream;

            public function stream_open(
                string $path,
                string $mode,
                int $options,
                ?string &$opened_path
            ): bool {
                $path = str_replace(static::WRAPPER_NAME . '://', '', $path);

                $this->stream = fopen($path, $mode);

                $opened_path = $path;

                ConsoleDebugger::output('STREAM OPENED', [
                    'path' => $path,
                    'mode' => $mode,
                    'options' => $options,
                    'opened_path' => $opened_path
                ]);

                //                stream_set_read_buffer($this->stream, 24);

                return true;
            }

            public function stream_close(): void
            {
                ConsoleDebugger::output('STREAM CLOSED');

                fclose($this->stream);
            }

            public function stream_write(string $data): int
            {
                $written = fwrite($this->stream, $data);

                ConsoleDebugger::output('WRITTEN', [
                    'data' => $data,
                    'bytes' => $written
                ]);

                return ($written !== false) ? $written : 0;
            }

            public function stream_read(int $count): string|false
            {
                ConsoleDebugger::output('READING', [
                    'count' => $count
                ]);

                return fread($this->stream, $count);
            }

            public function stream_seek(int $offset, int $whence = SEEK_SET): bool
            {
                ConsoleDebugger::output('SEEK', [
                    'offset' => $offset,
                    'whence' => $whence
                ]);

                $result = fseek($this->stream, $offset, $whence);

                return $result === 0;
            }

            public function stream_tell()
            {
                ConsoleDebugger::output('TELL');

                return ftell($this->stream);
            }

            public function stream_eof(): bool
            {
                ConsoleDebugger::output('EOF CHECK');

                return feof($this->stream);
            }
        };
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/


    /**
     * @test
     *
     * @return void
     */
    public function canWrapStream()
    {
        $wrapper = $this->defineDecorator();

        // --------------------------------------------------------- //

        stream_wrapper_register($wrapper::WRAPPER_NAME, $wrapper::class);

        $filename = 'php://memory';
        $stream = fopen($wrapper::WRAPPER_NAME . '://' . $filename, "w+b");

        fwrite($stream, "a");
        fwrite($stream, "b");
        fwrite($stream, "c");

        rewind($stream);

        $output = [];
        while (feof($stream) === false) {
            $output[] = fread($stream, 1);
        }

        fclose($stream);

        ConsoleDebugger::output($output);

        // Test conclusion ... well, only if we register and wrap from the beginning, will this
        // be possible. Alternatively, if an existing resource is given, then we need to wrap it
        // and return our own, which delegates to the original resource...
        // E.g. Use context to store original resource.
        // @see https://github.com/icewind1991/Streams - good example on how such can be done.
    }
}
