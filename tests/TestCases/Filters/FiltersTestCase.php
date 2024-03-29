<?php

namespace Aedart\Tests\TestCases\Filters;

use Aedart\Contracts\Filters\Builder;
use Aedart\Contracts\Filters\Processor;
use Aedart\Filters\Builders\GenericBuilder;
use Aedart\Filters\Providers\FiltersServiceProvider;
use Aedart\Testing\TestCases\LaravelTestCase;
use Aedart\Tests\Helpers\Dummies\Filters\Processors\NullProcessor;
use Illuminate\Http\Request;

/**
 * Filters Test Case
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\TestCases\Filters
 */
abstract class FiltersTestCase extends LaravelTestCase
{
    /*****************************************************************
     * Setup
     ****************************************************************/

    /**
     * {@inheritdoc}
     */
    protected function getPackageProviders($app)
    {
        return [
            FiltersServiceProvider::class
        ];
    }

    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Creates a new generic filters builder
     *
     * @param array $processors [optional]
     * @param Request|null $request [optional] Defaults to new request when none given
     *
     * @return Builder
     */
    public function makeGenericBuilder(array $processors = [], ?Request $request = null): Builder
    {
        $request = $request ?? $this->makeRequest();

        return GenericBuilder::make($request)
            ->setProcessors($processors);
    }

    /**
     * Creates a new "null" processor instance
     *
     * @param array $options [optional]
     *
     * @return Processor
     */
    public function makeNullProcessor(array $options = []): Processor
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
}
