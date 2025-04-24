<?php

namespace Aedart\Tests\Integration\Streams;

use Aedart\Streams\Stream;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Streams\StreamTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * D1_ReadCharactersTest
 *
 * @group streams
 * @group streams-d1
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams
 */
#[Group(
    'streams',
    'stream-d1',
)]
class D1_ReadCharactersTest extends StreamTestCase
{
    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canReadSingleCharacter()
    {
        $content = 'abc';
        $resource = fopen('php://memory', 'r+b');
        fwrite($resource, $content);

        $stream = Stream::make($resource)
            ->positionToStart();

        $resultA = $stream->readCharacter();
        $resultB = $stream->readCharacter();
        $resultC = $stream->readCharacter();

        $this->assertSame('a', $resultA);
        $this->assertSame('b', $resultB);
        $this->assertSame('c', $resultC);
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canReadAllCharacters()
    {
        $content = 'abc';
        $resource = fopen('php://memory', 'r+b');
        fwrite($resource, $content);

        $stream = Stream::make($resource)
            ->positionToStart();

        $buffer = '';
        $iterator = $stream->readAllCharacters();
        foreach ($iterator as $character) {
            ConsoleDebugger::output($character);

            $buffer .= $character;
        }

        $this->assertSame($content, $buffer);
    }
}
