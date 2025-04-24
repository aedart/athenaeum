<?php

namespace Aedart\Tests\Integration\Streams;

use Aedart\Contracts\Streams\Meta\Repository;
use Aedart\Streams\Meta\Repository as DefaultMetaRepository;
use Aedart\Streams\Stream;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Streams\StreamTestCase;
use Aedart\Utils\Arr;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * X2_MetaTest
 *
 * @group streams
 * @group streams-x2
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams
 */
#[Group(
    'streams',
    'stream-x2',
)]
class X2_MetaTest extends StreamTestCase
{
    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canResolveNullMeta()
    {
        $resource = fopen('php://memory', 'rb');
        $stream = Stream::make($resource);

        $result = $stream->meta();

        $this->assertInstanceOf(Repository::class, $result);
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canResolveMetaFromArray()
    {
        $meta = [
            'foo' => 'bar'
        ];

        $resource = fopen('php://memory', 'rb');
        $stream = Stream::make($resource, $meta);

        $result = $stream->meta();

        $this->assertInstanceOf(Repository::class, $result);
        $this->assertTrue($result->has('foo'));
        $this->assertsame($meta['foo'], $result->get('foo'));
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canResolveMetaFromMetaRepository()
    {
        $meta = new DefaultMetaRepository([
            'foo' => 'bar'
        ]);

        $resource = fopen('php://memory', 'rb');
        $stream = Stream::make($resource, $meta);

        $result = $stream->meta();

        $this->assertInstanceOf(Repository::class, $result);
        $this->assertSame($meta, $result);
        $this->assertsame($meta->get('foo'), $result->get('foo'));
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function mergesRawMetaIntoRepository()
    {
        $resource = fopen('php://memory', 'rb');
        $stream = Stream::make($resource);

        $raw = $stream->rawMeta();
        $result = $stream->meta();

        $keys = array_keys(Arr::dot($raw));
        foreach ($keys as $key) {
            ConsoleDebugger::output($key);

            $this->assertTrue($result->has($key));
        }
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canSetMetaDataDirectly()
    {
        $resource = fopen('php://memory', 'rb');
        $stream = Stream::make($resource);

        $stream->meta()->set('acme.foo', 'bar');

        $this->assertsame($stream->meta()->get('acme.foo'), 'bar');
    }

    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    #[Test]
    public function canObtainRawMeta()
    {
        $resource = fopen('php://memory', 'rb');
        $stream = Stream::make($resource);

        $raw = $stream->rawMeta();

        ConsoleDebugger::output($raw);

        $this->assertNotEmpty($raw);
    }
}
