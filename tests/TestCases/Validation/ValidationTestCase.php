<?php

namespace Aedart\Tests\TestCases\Validation;

use Aedart\Testing\TestCases\LaravelTestCase;
use Aedart\Validation\Providers\ValidationServiceProvider;

/**
 * Validation Test-Case
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\TestCases\Validation
 */
abstract class ValidationTestCase extends LaravelTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getPackageProviders($app)
    {
        return [
            ValidationServiceProvider::class
        ];
    }
}