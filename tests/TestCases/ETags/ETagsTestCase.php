<?php

namespace Aedart\Tests\TestCases\ETags;

use Aedart\Config\Providers\ConfigLoaderServiceProvider;
use Aedart\Config\Traits\ConfigLoaderTrait;
use Aedart\Contracts\ETags\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\ETags\Generator;
use Aedart\ETags\Providers\ETagsServiceProvider;
use Aedart\ETags\Traits\ETagGeneratorFactoryTrait;
use Aedart\Testing\TestCases\LaravelTestCase;
use Codeception\Configuration;
use Illuminate\Http\Request;

/**
 * Etags Test Case
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\TestCases\ETags
 */
abstract class ETagsTestCase extends LaravelTestCase
{
    use ETagGeneratorFactoryTrait;
    use ConfigLoaderTrait;

    /*****************************************************************
     * Setup
     ****************************************************************/

    /**
     * @inheritDoc
     */
    protected function _before()
    {
        parent::_before();

        $this->getConfigLoader()
            ->setDirectory($this->directory())
            ->load();
    }

    /**
     * @inheritDoc
     */
    protected function _after()
    {
        parent::_after();
    }

    /**
     * {@inheritdoc}
     */
    protected function getPackageProviders($app)
    {
        return [
            ConfigLoaderServiceProvider::class,
            ETagsServiceProvider::class,
        ];
    }

    /**
     * Returns the path to configuration files
     *
     * @return string
     */
    public function directory(): string
    {
        return Configuration::dataDir() . 'configs/etags';
    }

    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Creates new ETag Generator or returns existing
     *
     * @param  string|null  $profile  [optional]
     * @param  array  $options  [optional]
     *
     * @return Generator
     *
     * @throws ProfileNotFoundException
     *@see \Aedart\Contracts\ETags\Factory::profile
     *
     */
    public function makeGenerator(string|null $profile = null, array $options = []): Generator
    {
        return $this->getEtagGeneratorFactory()->profile($profile, $options);
    }

    /**
     * Creates a new request with given header values
     *
     * @param  string|null  $ifMatch  [optional] Full header value
     * @param  string|null  $ifNoneMatch  [optional] Full header value
     * @param  string|null  $ifModifiedSince  [optional] Full header value
     * @param  string|null  $ifUnmodifiedSince  [optional] Full header value
     * @param  string|null  $ifRange  [optional] Etag, HTTP-Date or null
     * @param  string|null  $range  [optional]
     * @param  string  $method  [optional]
     *
     * @return Request
     */
    public function createRequest(
        string|null $ifMatch = null,
        string|null $ifNoneMatch = null,
        string|null $ifModifiedSince = null,
        string|null $ifUnmodifiedSince = null,
        string|null $ifRange = null,
        string|null $range = null,
        string $method = 'post'
    ): Request {
        $headers = array_filter([
            'HTTP_IF_MATCH' => $ifMatch,
            'HTTP_IF_NONE_MATCH' => $ifNoneMatch,
            'HTTP_IF_MODIFIED_SINCE' => $ifModifiedSince,
            'HTTP_IF_UNMODIFIED_SINCE' => $ifUnmodifiedSince,
            'HTTP_IF_RANGE' => $ifRange,
            'HTTP_RANGE' => $range,
        ], fn ($value) => !empty($value));

        return Request::create('/test', strtoupper($method), [], [], [], $headers);
    }
}
