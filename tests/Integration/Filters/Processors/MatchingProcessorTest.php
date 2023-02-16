<?php

namespace Aedart\Tests\Integration\Filters\Processors;

use Aedart\Contracts\Database\Query\FieldCriteria;
use Aedart\Filters\Processors\MatchingProcessor;
use Aedart\Tests\TestCases\Filters\FiltersTestCase;

/**
 * MatchingProcessorTest
 *
 * @group filters
 * @group filters-processors
 * @group filters-matching-processor
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Filters\Processors
 */
class MatchingProcessorTest extends FiltersTestCase
{
    /**
     * @test
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function setsLogicalOperatorAsMeta()
    {
        $key = 'match';
        $processors = [
            $key => MatchingProcessor::make()
        ];

        $builder = $this->makeGenericBuilder($processors, $this->makeRequest(
            'https://some-url.org/api/v1',
            'GET',
            [
                'match' => 'any'
            ]
        ));

        $built = $builder->build();

        $this->assertTrue($built->hasMeta($key), 'Meta not set');
        $this->assertSame(FieldCriteria::OR, $built->getMeta($key));
    }
}
