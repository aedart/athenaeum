<?php

namespace Aedart\Tests\Unit\Http\Clients\Responses;

use Aedart\Contracts\Http\Clients\Exceptions\InvalidStatusCodeException;
use Aedart\Contracts\Http\Clients\Responses\Status;
use Aedart\Http\Clients\Responses\ResponseStatus;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
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
#[Group(
    'http-clients',
    'http-status',
    'response-status',
)]
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
    public function makeStatus(int $code, string $phrase = ''): Status
    {
        return ResponseStatus::make($code, $phrase);
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
     * Data Providers
     ****************************************************************/

    /**
     * Status Code Data provider
     *
     * @return array[]
     */
    public function statusCodeProvider(): array
    {
        return [
            // Informational responses (100 – 199)
            '100 Continue' => [100, 'isContinue'],
            '101 Switching Protocols' => [101, 'isSwitchingProtocols'],
            '102 Processing' => [102, 'isProcessing'],
            '103 Early Hints' => [103, 'isEarlyHints'],

            // Successful responses (200 – 299)
            '200 Ok' => [200, 'isOk'],
            '201 Created' => [201, 'isCreated'],
            '202 Accepted' => [202, 'isAccepted'],
            '203 Non-Authoritative Information' => [203, 'isNonAuthoritativeInformation'],
            '204 No Content' => [204, 'isNoContent'],
            '205 Reset Content' => [205, 'isResetContent'],
            '206 Partial Content' => [206, 'isPartialContent'],
            '207 Multi-Status' => [207, 'isMultiStatus'],
            '208 Already Reported' => [208, 'isAlreadyReported'],
            '226 IM Used' => [226, 'isImUsed'],

            // Redirection messages (300 – 399)
            '300 Multiple Choices' => [300, 'isMultipleChoices'],
            '301 Moved Permanently' => [301, 'isMovedPermanently'],
            '302 Found' => [302, 'isFound'],
            '303 See Other' => [303, 'isSeeOther'],
            '304 Not Modified' => [304, 'isNotModified'],
            '307 Temporary Redirect' => [307, 'isTemporaryRedirect'],
            '308 Permanent Redirect' => [308, 'isPermanentRedirect'],

            // Client error responses (400 – 499)
            '400 Bad Request' => [400, 'isBadRequest'],
            '401 Unauthorized' => [401, 'isUnauthorized'],
            '402 Payment Required' => [402, 'isPaymentRequired'],
            '403 Forbidden' => [403, 'isForbidden'],
            '404 Not Found' => [404, 'isNotFound'],
            '405 Method Not Allowed' => [405, 'isMethodNotAllowed'],
            '406 Not Acceptable' => [406, 'isNotAcceptable'],
            '407 Proxy Authentication Required' => [407, 'isProxyAuthenticationRequired'],
            '408 Request Timeout' => [408, 'isRequestTimeout'],
            '409 Conflict' => [409, 'isConflict'],
            '410 Gone' => [410, 'isGone'],
            '411 Length Required' => [411, 'isLengthRequired'],
            '412 Precondition Failed' => [412, 'isPreconditionFailed'],
            '413 Payload Too Large' => [413, 'isPayloadTooLarge'],
            '414 URI Too Long' => [414, 'isUriTooLong'],
            '415 Unsupported Media Type' => [415, 'isUnsupportedMediaType'],
            '416 Range Not Satisfiable' => [416, 'isRangeNotSatisfiable'],
            '417 Expectation Failed' => [417, 'isExpectationFailed'],
            '418 I\'m a teapot' => [418, 'isTeapot'],
            '421 Misdirected Request' => [421, 'isMisdirectedRequest'],
            '422 Unprocessable Entity' => [422, 'isUnprocessableEntity'],
            '423 Locked' => [423, 'isLocked'],
            '424 Failed Dependency' => [424, 'isFailedDependency'],
            '425 Too Early' => [425, 'isTooEarly'],
            '426 Upgrade Required' => [426, 'isUpgradeRequired'],
            '428 Precondition Required' => [428, 'isPreconditionRequired'],
            '429 Too Many Requests' => [429, 'isTooManyRequests'],
            '431 Request Header Fields Too Large' => [431, 'isRequestHeaderFieldsTooLarge'],
            '451 Unavailable For Legal Reasons' => [451, 'isUnavailableForLegalReasons'],

            // Server error responses (500 – 599)
            '500 Internal Server Error' => [500, 'isInternalServerError'],
            '501 Not Implemented' => [501, 'isNotImplemented'],
            '502 Bad Gateway' => [502, 'isBadGateway'],
            '503 Service Unavailable' => [503, 'isServiceUnavailable'],
            '504 Gateway Timeout' => [504, 'isGatewayTimeout'],
            '505 HTTP Version Not Supported' => [505, 'isHttpVersionNotSupported'],
            '506 Variant Also Negotiates' => [506, 'isVariantAlsoNegotiates'],
            '507 Insufficient Storage' => [507, 'isInsufficientStorage'],
            '508 Loop Detected' => [508, 'isLoopDetected'],
            '510 Not Extended' => [510, 'isNotExtended'],
            '511 Network Authentication Required' => [511, 'isNetworkAuthenticationRequired'],
        ];
    }

    /*****************************************************************
     * Actual tests
     ****************************************************************/

    /**
     * @test
     *
     * @throws InvalidStatusCodeException
     */
    #[Test]
    public function failsWhenStatusIsBelowInformational()
    {
        $this->expectException(InvalidStatusCodeException::class);

        $this->makeStatus(99);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws InvalidStatusCodeException
     */
    #[Test]
    public function failsWhenStatusIsAboveServerError(): void
    {
        $this->expectException(InvalidStatusCodeException::class);

        $this->makeStatus(600);
    }

    /**
     * @test
     *
     * @throws InvalidStatusCodeException
     */
    #[Test]
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
    #[Test]
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
    #[Test]
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
    #[Test]
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
    #[Test]
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
    #[Test]
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
    #[Test]
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
    #[Test]
    public function canCreateFromResponse()
    {
        $response = new Response(204);

        $status = $this->fromResponse($response);

        ConsoleDebugger::output($status);

        $this->assertSame($response->getStatusCode(), $status->code(), 'Incorrect status code');
        $this->assertSame($response->getReasonPhrase(), $status->phrase(), 'Incorrect status code');
    }

    /**
     * @test
     *
     * @throws InvalidStatusCodeException
     */
    #[Test]
    public function canConvertIntoString()
    {
        $response = new Response(204);

        $status = $this->fromResponse($response);

        ConsoleDebugger::output((string) $status);

        $this->assertSame('204 No Content', (string) $status);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws InvalidStatusCodeException
     */
    #[Test]
    public function canMatchAgainstOtherStatus(): void
    {
        $statusA = $this->makeStatus(200);
        $statusB = $this->makeStatus(200);
        $statusC = $this->makeStatus(304);

        $this->assertTrue($statusA->matches($statusB), 'A and B should match');
        $this->assertTrue($statusB->matches($statusA), 'B and A should match');

        $this->assertFalse($statusA->matches($statusC), 'A and C should NOT match');
        $this->assertFalse($statusB->matches($statusC), 'B and C should NOT match');
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws InvalidStatusCodeException
     */
    #[Test]
    public function canDetermineIfCodeSatisfies(): void
    {
        $status = $this->makeStatus(201);

        $this->assertFalse($status->satisfies(200), '200 should not satisfy 201');
        $this->assertFalse($status->satisfies($this->makeStatus(204)), '204 (instance) should not satisfy 201');

        $this->assertTrue($status->satisfies(201), '201 should satisfy 201');
        $this->assertTrue($status->satisfies($this->makeStatus(201)), '204 (instance) should satisfy 201');

        $this->assertTrue($status->satisfies([ 200, 204, $this->makeStatus(201) ]), 'List of codes should satisfy 201');
    }

    /**
     * @test
     * @dataProvider statusCodeProvider
     *
     * @param int $code
     * @param string $method
     *
     * @return void
     *
     * @throws InvalidStatusCodeException
     */
    #[DataProvider('statusCodeProvider')]
    #[Test]
    public function isStatus(int $code, string $method): void
    {
        $status = $this->makeStatus($code);

        ConsoleDebugger::output((string) $status);

        $result = $status->{$method}();

        $this->assertTrue($result, sprintf('%s should had returned true for status %s', $method, $code));
    }
}
