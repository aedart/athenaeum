<?php

namespace Aedart\Tests\Integration\Filters\Builders;

use Aedart\Contracts\Filters\BuiltFiltersMap;
use Aedart\Tests\Helpers\Dummies\Filters\Processors\InvalidParamFailProcessor;
use Aedart\Tests\Helpers\Dummies\Filters\Processors\NullProcessor;
use Aedart\Tests\TestCases\Filters\FiltersTestCase;
use Codeception\Attribute\Group;
use Illuminate\Validation\ValidationException;
use PHPUnit\Framework\Attributes\Test;

/**
 * BaseBuilderTest
 *
 * @group filters
 * @group filters-builder
 * @group filters-base-builder
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Filters\Builders
 */
#[Group(
    'filters',
    'filters-builder',
    'filters-base-builder',
)]
class BaseBuilderTest extends FiltersTestCase
{
    /**
     * @test
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    #[Test]
    public function canBuild()
    {
        $processors = [
            'a' => NullProcessor::make(),
            'b' => NullProcessor::make(),
            'c' => NullProcessor::make(),
        ];

        $builder = $this->makeGenericBuilder($processors, $this->makeRequest(
            'https://some-url.org/api/v1',
            'GET',
            [
                'a' => true,
                'b' => true,
                'c' => true
            ]
        ));

        $built = $builder->build();
        $this->assertInstanceOf(BuiltFiltersMap::class, $built);
        $this->assertNotNull($built);

        // ------------------------------------------------- //

        foreach ($processors as $processor) {
            $this->assertTrue($processor->isProcessed, 'Processor was not invoked');
        }
    }

    /**
     * @test
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    #[Test]
    public function invokesProcessorsThatAreForced()
    {
        $processors = [
            'a' => NullProcessor::make(),
            'b' => NullProcessor::make()
                ->force(),
            'c' => NullProcessor::make(),
        ];

        $builder = $this->makeGenericBuilder($processors, $this->makeRequest(
            'https://some-url.org/api/v1',
            'GET',
            [
                'a' => true,
                // 'b' => true, // Processor should still be applied
                'c' => true
            ]
        ));

        $builder->build();

        // ------------------------------------------------- //

        foreach ($processors as $processor) {
            $this->assertTrue($processor->isProcessed, 'Processor was not invoked');
        }
    }

    /**
     * @test
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    #[Test]
    public function failsWhenProcessorDetectsInvalidParameter()
    {
        $this->expectException(ValidationException::class);

        $processors = [
            'a' => NullProcessor::make(),
            'b' => NullProcessor::make(),
            'c' => InvalidParamFailProcessor::make(),
        ];

        $this->makeGenericBuilder($processors, $this->makeRequest(
            'https://some-url.org/api/v1',
            'GET',
            [
                'a' => true,
                'b' => true,
                'c' => true
            ]
        ))->build();
    }
}
