<?php

namespace Aedart\Tests\TestCases\Flysystem\Db;

use Aedart\Flysystem\Db\Providers\FlysystemDatabaseAdapterServiceProvider;
use Aedart\Tests\TestCases\Flysystem\FlysystemTestCase;

/**
 * Flysystem Db Test Case
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\TestCases\Flysystem\Db
 */
abstract class FlysystemDbTestCase extends FlysystemTestCase
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
            FlysystemDatabaseAdapterServiceProvider::class
        ];
    }
}