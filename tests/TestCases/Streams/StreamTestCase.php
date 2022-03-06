<?php

namespace Aedart\Tests\TestCases\Streams;

use Aedart\Streams\Providers\StreamServiceProvider;
use Aedart\Testing\TestCases\LaravelTestCase;

/**
 * Stream Test-Case
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\TestCases\Streams
 */
abstract class StreamTestCase extends LaravelTestCase
{
    /*****************************************************************
     * Setup Methods
     ****************************************************************/

    /**
     * {@inheritdoc}
     */
    protected function getPackageProviders($app)
    {
        return [
            StreamServiceProvider::class
        ];
    }
}
