<?php

namespace Aedart\Tests\Unit\Http\Clients\Helpers\Guzzle;

use Aedart\Http\Clients\Requests\Builders\Guzzle\PayloadData;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Codeception\Attribute\Group;
use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\Attributes\Test;

/**
 * DataExtractorTest
 *
 * @group http-clients
 * @group guzzle
 * @group guzzle-payload-data
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Http\Clients\Helpers\Guzzle
 */
#[Group(
    'http-clients',
    'guzzle',
    'guzzle-payload-data',
)]
class PayloadDataTest extends UnitTestCase
{
    /**
     * @test
     */
    #[Test]
    public function canExtractDataFromOptions()
    {
        $options = [
            RequestOptions::FORM_PARAMS => [
                'name' => 'John Due',
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

        $data = PayloadData::extract($options);

        ConsoleDebugger::output($data);

        $this->assertIsArray($data);
        $this->assertArrayHasKey('name', $data);
        $this->assertArrayHasKey('mail', $data);
        $this->assertArrayHasKey('phone', $data);
        $this->assertArrayNotHasKey('address', $data);
    }

    /**
     * @test
     */
    #[Test]
    public function extractsOnlyRawBodyIfStated()
    {
        $options = [
            RequestOptions::FORM_PARAMS => [
                'name' => 'John Due',
            ],
            RequestOptions::JSON => [
                'mail' => 'john.due@example.com',
            ],
            RequestOptions::MULTIPART => [
                'phone' => '55 55 55 55',
            ],
            'other' => [
                'address' => 'Somewhere Str. 77'
            ],

            // NOTE: This is the ONLY one used, when
            // stated...
            RequestOptions::BODY => 'raw payload...'
        ];

        $data = PayloadData::extract($options);

        ConsoleDebugger::output($data);

        $this->assertIsString($data);
        $this->assertSame('raw payload...', $data);
    }
}
