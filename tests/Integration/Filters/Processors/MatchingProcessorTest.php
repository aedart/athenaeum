<?php

namespace Aedart\Tests\Integration\Filters\Processors;

use Aedart\Contracts\Database\Query\FieldCriteria;
use Aedart\Filters\Processors\MatchingProcessor;
use Aedart\Tests\TestCases\Filters\FiltersTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * MatchingProcessorTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Filters\Processors
 */
#[Group(
    'filters',
    'filters-processors',
    'filters-matching-processor'
)]
class MatchingProcessorTest extends FiltersTestCase
{
    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    #[Test]
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
