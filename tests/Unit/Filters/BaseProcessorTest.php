<?php

namespace Aedart\Tests\Unit\Filters;

use Aedart\Contracts\Filters\Processor;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Tests\Helpers\Dummies\Filters\Processors\NullProcessor;
use Codeception\Attribute\Group;
use Illuminate\Http\Request;
use PHPUnit\Framework\Attributes\Test;
use RuntimeException;

/**
 * BaseProcessorTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Filters
 */
#[Group(
    'filters',
    'base-processor',
)]
class BaseProcessorTest extends UnitTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Creates a new processor instance
     *
     * @param array $options [optional]
     *
     * @return Processor
     */
    public function makeProcessor(array $options = []): Processor
    {
        return NullProcessor::make($options);
    }
    /**
     * Creates a new request instance
     *
     * @param string $uri [optional]
     * @param string $method [optional]
     * @param array $parameters [optional]
     * @param array $cookies [optional]
     * @param array $files [optional]
     * @param array $server [optional]
     * @param null $content [optional]
     *
     * @return Request
     */
    public function makeRequest(
        string $uri = 'https://some-url.org/api/v1',
        string $method = 'GET',
        array $parameters = [],
        array $cookies = [],
        array $files = [],
        array $server = [],
        $content = null
    ): Request {
        return Request::create($uri, $method, $parameters, $cookies, $files, $server, $content);
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    #[Test]
    public function canCreateInstance()
    {
        $processor = $this->makeProcessor();

        $this->assertNotNull($processor);
    }

    #[Test]
    public function canAssignRequest()
    {
        $request = $this->makeRequest();

        $processor = $this
            ->makeProcessor()
            ->fromRequest($request);

        $this->assertSame($request, $processor->request());
    }

    #[Test]
    public function failsWhenRequestNotSpecified()
    {
        $this->expectException(RuntimeException::class);

        $this
            ->makeProcessor()
            ->request();
    }

    #[Test]
    public function canAssignParameter()
    {
        $param = $this->getFaker()->slug();

        $processor = $this
            ->makeProcessor()
            ->usingParameter($param);

        $this->assertSame($param, $processor->parameter());
    }

    #[Test]
    public function failsWhenNoParameterAssigned()
    {
        $this->expectException(RuntimeException::class);

        $this
            ->makeProcessor()
            ->parameter();
    }

    #[Test]
    public function canObtainValue()
    {
        $expected = $this->getFaker()->name();

        $request = $this
            ->makeRequest('https://some-url.org/api/v1', 'GET', [
                'name' => $expected
            ]);

        $processor = $this
            ->makeProcessor()
            ->fromRequest($request)
            ->usingParameter('name');

        $value = $processor->value();

        $this->assertSame($expected, $value);
    }

    #[Test]
    public function canSetForceState()
    {
        $processor = $this->makeProcessor();

        // Default force state should be false
        $this->assertFalse($processor->mustBeApplied(), 'Incorrect default force state');

        $processor->force();
        $this->assertTrue($processor->mustBeApplied());
    }
}
