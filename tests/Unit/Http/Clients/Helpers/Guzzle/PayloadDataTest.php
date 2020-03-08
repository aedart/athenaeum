<?php

namespace Aedart\Tests\Unit\Http\Clients\Helpers\Guzzle;

use Aedart\Http\Clients\Requests\Builders\Guzzle\DataExtractor;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use GuzzleHttp\RequestOptions;

/**
 * DataExtractorTest
 *
 * @group http-clients
 * @group guzzle
 * @group guzzle-data-extractor
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Http\Clients\Helpers\Guzzle
 */
class DataExtractorTest extends UnitTestCase
{
    /**
     * @test
     */
    public function canExtractDataFromOptions()
    {
        $options = [
            RequestOptions::FORM_PARAMS => [
                'name' => 'John Due',
            ],
            RequestOptions::BODY => [
                'age' => '32',
            ],
            RequestOptions::JSON => [
                'mail' => 'john.due@example.com',
            ],
            RequestOptions::MULTIPART => [
                'phone' => '55 55 55 55',
            ],
            'other' => [
                'address' => 'Somewhere Str. 77'
            ]
        ];

        $data = DataExtractor::extract($options);

        ConsoleDebugger::output($data);

        $this->assertArrayHasKey('name', $data);
        $this->assertArrayHasKey('age', $data);
        $this->assertArrayHasKey('mail', $data);
        $this->assertArrayHasKey('phone', $data);
        $this->assertArrayNotHasKey('address', $data);
    }
}