<?php

namespace Aedart\Tests\TestCases\Http;

use Aedart\Http\Messages\Providers\HttpSerializationServiceProvider;
use Aedart\Http\Messages\Traits\HttpSerializerFactoryTrait;
use Aedart\Testing\TestCases\LaravelTestCase;

/**
 * Http Serialization Test Case
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\TestCases\Http
 */
abstract class HttpSerializationTestCase extends LaravelTestCase
{
    use HttpSerializerFactoryTrait;

    /*****************************************************************
     * Setup
     ****************************************************************/

    /**
     * {@inheritdoc}
     */
    protected function getPackageProviders($app)
    {
        return [
            HttpSerializationServiceProvider::class
        ];
    }

    /*****************************************************************
     * Helpers
     ****************************************************************/


}
