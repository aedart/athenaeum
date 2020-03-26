<?php

namespace Aedart\Tests\Unit\Http\Clients\Responses;

use Aedart\Contracts\Http\Clients\Exceptions\InvalidStatusCodeException;
use Aedart\Contracts\Http\Clients\Responses\Status;
use Aedart\Http\Clients\Responses\ResponseStatus;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * ResponseStatusTest
 *
 * @group http-clients
 * @group http-status
 * @group response-status
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Http\Clients\Responses
 */
class ResponseStatusTest extends UnitTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Creates a new Http Response Status instance
     *
     * @param int $code
     * @param string $phrase [optional]
     * @return Status
     *
     * @throws InvalidStatusCodeException
     */
    public function makeStatus($code, string $phrase = ''): Status
    {
        return new ResponseStatus($code, $phrase);
    }

    /**
     * Creates a new Http Response Status instance from given Response
     *
     * @param ResponseInterface $response
     * @return Status
     *
     * @throws InvalidStatusCodeException
     */
    public function fromResponse(ResponseInterface $response): Status
    {
        return ResponseStatus::fromResponse($response);
    }

    /*****************************************************************
     * Actual tests
     ****************************************************************/

    /**
     * @test
     *
     * @throws InvalidStatusCodeException
     */
    public function failsWhenStatusCodeIsInvalid()
    {
        $this->expectException(InvalidStatusCodeException::class);

        $this->makeStatus(-100);
    }

    /**
     * @test
     *
     * @throws InvalidStatusCodeException
     */
    public function canObtainStatusCode()
    {
        $status = $this->makeStatus(200);

        $this->assertSame(200, $status->code());
    }

    /**
     * @test
     *
     * @throws InvalidStatusCodeException
     */
    public function canObtainReasonPhrase()
    {
        $status = $this->makeStatus(200, 'ok');

        $this->assertSame('ok', $status->phrase());
    }

    /**
     * @test
     *
     * @throws InvalidStatusCodeException
     */
    public function canDetermineIfInformational()
    {
        $status = $this->makeStatus(101);

        $this->assertTrue($status->isInformational(), 'Should be informational');

        $this->assertFalse($status->isSuccessful(), 'Should not be successful');
        $this->assertFalse($status->isRedirection(), 'Should not be redirection');
        $this->assertFalse($status->isClientError(), 'Should not be client error');
        $this->assertFalse($status->isServerError(), 'Should not be server error');
    }

    /**
     * @test
     *
     * @throws InvalidStatusCodeException
     */
    public function canDetermineIfSuccessful()
    {
        $status = $this->makeStatus(202);

        $this->assertTrue($status->isSuccessful(), 'Should be successful');

        $this->assertFalse($status->isInformational(), 'Should not be informational');
        $this->assertFalse($status->isRedirection(), 'Should not be redirection');
        $this->assertFalse($status->isClientError(), 'Should not be client error');
        $this->assertFalse($status->isServerError(), 'Should not be server error');
    }

    /**
     * @test
     *
     * @throws InvalidStatusCodeException
     */
    public function canDetermineIfRedirection()
    {
        $status = $this->makeStatus(300);

        $this->assertTrue($status->isRedirection(), 'Should be redirection');

        $this->assertFalse($status->isInformational(), 'Should not be informational');
        $this->assertFalse($status->isSuccessful(), 'Should not be successful');
        $this->assertFalse($status->isClientError(), 'Should not be client error');
        $this->assertFalse($status->isServerError(), 'Should not be server error');
    }

    /**
     * @test
     *
     * @throws InvalidStatusCodeException
     */
    public function canDetermineIfClientError()
    {
        $status = $this->makeStatus(404);

        $this->assertTrue($status->isClientError(), 'Should be client error');

        $this->assertFalse($status->isInformational(), 'Should not be informational');
        $this->assertFalse($status->isSuccessful(), 'Should not be successful');
        $this->assertFalse($status->isRedirection(), 'Should not be redirection');
        $this->assertFalse($status->isServerError(), 'Should not be server error');
    }

    /**
     * @test
     *
     * @throws InvalidStatusCodeException
     */
    public function canDetermineIfServerError()
    {
        $status = $this->makeStatus(503);

        $this->assertTrue($status->isServerError(), 'Should be server error');

        $this->assertFalse($status->isInformational(), 'Should not be informational');
        $this->assertFalse($status->isSuccessful(), 'Should not be successful');
        $this->assertFalse($status->isRedirection(), 'Should not be redirection');
        $this->assertFalse($status->isClientError(), 'Should not be client error');
    }

    /**
     * @test
     *
     * @throws InvalidStatusCodeException
     */
    public function canCreateFromResponse()
    {
        $response = new Response(204);

        $status = $this->fromResponse($response);

        ConsoleDebugger::output($status);

        $this->assertSame($response->getStatusCode(), $status->code(), 'Incorrect status code');
        $this->assertSame($response->getReasonPhrase(), $status->phrase(), 'Incorrect status code');
    }
}
