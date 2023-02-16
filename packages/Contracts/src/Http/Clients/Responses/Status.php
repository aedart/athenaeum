<?php

namespace Aedart\Contracts\Http\Clients\Responses;

use Aedart\Contracts\Http\Clients\Exceptions\InvalidStatusCodeException;
use Psr\Http\Message\ResponseInterface;
use Stringable;

/**
 * Response Http Status
 *
 * Contains Http status code and phrase of a response
 *
 * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Clients\Responses
 */
interface Status extends Stringable
{
    /**
     * Returns the Http response status code
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     *
     * @return int
     */
    public function code(): int;

    /**
     * Returns the Http response status reason phrase
     *
     * @return string
     */
    public function phrase(): string;

    /*****************************************************************
     * Compare methods
     ****************************************************************/

    /**
     * Determine if this status has the exact same code as provided
     *
     * @see matches()
     *
     * @param int $expectedCode Http Status code to match against
     *
     * @return bool
     */
    public function is(int $expectedCode): bool;

    /**
     * Determine if this status has the exact same code as provided
     *
     * @see is()
     *
     * @param int|Status $status
     *
     * @return bool
     */
    public function matches(int|self $status): bool;

    /**
     * Determine if this status satisfies (matches) one of the given status codes
     *
     * @param int|Status|int[]|Status[] $status
     *
     * @return bool
     */
    public function satisfies(int|self|array $status): bool;

    /*****************************************************************
     * 1xx Informational
     ****************************************************************/

    /**
     * Determine if status code is "Informational" (1xx)
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status#Information_responses
     *
     * @return bool
     */
    public function isInformational(): bool;

    /**
     * Determine if status code is "100 Continue"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/100
     *
     * @return bool
     */
    public function isContinue(): bool;

    /**
     * Determine if status code is "101 Switching Protocols"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/101
     *
     * @return bool
     */
    public function isSwitchingProtocols(): bool;

    /**
     * Determine if status code is "102 Processing"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     *
     * @return bool
     */
    public function isProcessing(): bool;

    /**
     * Determine if status code is "103 Early Hints"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/103
     *
     * @return bool
     */
    public function isEarlyHints(): bool;

    /*****************************************************************
     * 2xx Successful
     ****************************************************************/

    /**
     * Determine is status code is "Successful" (2xx)
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status#Successful_responses
     *
     * @return bool
     */
    public function isSuccessful(): bool;

    /**
     * Determine if status code is "200 Ok"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/200
     *
     * @return bool
     */
    public function isOk(): bool;

    /**
     * Determine if status code is "201 Created"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/201
     *
     * @return bool
     */
    public function isCreated(): bool;

    /**
     * Determine if status code is "202 Accepted"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/202
     *
     * @return bool
     */
    public function isAccepted(): bool;

    /**
     * Determine if status code is "203 Non-Authoritative Information"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/203
     *
     * @return bool
     */
    public function isNonAuthoritativeInformation(): bool;

    /**
     * Determine if status code is "204 No Content"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/204
     *
     * @return bool
     */
    public function isNoContent(): bool;

    /**
     * Determine if status code is "205 Reset Content"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/205
     *
     * @return bool
     */
    public function isResetContent(): bool;

    /**
     * Determine if status code is "206 Partial Content"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/206
     *
     * @return bool
     */
    public function isPartialContent(): bool;

    /**
     * Determine if status code is "207 Multi-Status"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     *
     * @return bool
     */
    public function isMultiStatus(): bool;

    /**
     * Determine if status code is "208 Already Reported"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     *
     * @return bool
     */
    public function isAlreadyReported(): bool;

    /**
     * Determine if status code is "226 IM Used"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     *
     * @return bool
     */
    public function isImUsed(): bool;

    /*****************************************************************
     * 3xx Redirection
     ****************************************************************/

    /**
     * Determine if status code is "Redirection" (3xx)
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status#Redirection_messages
     *
     * @return bool
     */
    public function isRedirection(): bool;

    /**
     * Determine if status code is "300 Multiple Choices"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/300
     *
     * @return bool
     */
    public function isMultipleChoices(): bool;

    /**
     * Determine if status code is "301 Moved Permanently"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/301
     *
     * @return bool
     */
    public function isMovedPermanently(): bool;

    /**
     * Determine if status code is "302 Found"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/302
     *
     * @return bool
     */
    public function isFound(): bool;

    /**
     * Determine if status code is "303 See Other"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/303
     *
     * @return bool
     */
    public function isSeeOther(): bool;

    /**
     * Determine if status code is "304 Not Modified"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/304
     *
     * @return bool
     */
    public function isNotModified(): bool;

    /**
     * Determine if status code is "307 Temporary Redirect"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/307
     *
     * @return bool
     */
    public function isTemporaryRedirect(): bool;

    /**
     * Determine if status code is "308 Permanent Redirect"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/308
     *
     * @return bool
     */
    public function isPermanentRedirect(): bool;

    /*****************************************************************
     * 4xx Client Error
     ****************************************************************/

    /**
     * Determine if status code is "Client Error" (4xx)
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status#Client_error_responses
     *
     * @return bool
     */
    public function isClientError(): bool;

    /**
     * Determine if status code is "400 Bad Request"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/400
     *
     * @return bool
     */
    public function isBadRequest(): bool;

    /**
     * Determine if status code is "401 Unauthorized"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/401
     *
     * @return bool
     */
    public function isUnauthorized(): bool;

    /**
     * Determine if status code is "402 Payment Required"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/402
     *
     * @return bool
     */
    public function isPaymentRequired(): bool;

    /**
     * Determine if status code is "403 Forbidden"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/403
     *
     * @return bool
     */
    public function isForbidden(): bool;

    /**
     * Determine if status code is "404 Not Found"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/404
     *
     * @return bool
     */
    public function isNotFound(): bool;

    /**
     * Determine if status code is "405 Method Not Allowed"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/405
     *
     * @return bool
     */
    public function isMethodNotAllowed(): bool;

    /**
     * Determine if status code is "406 Not Acceptable"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/406
     *
     * @return bool
     */
    public function isNotAcceptable(): bool;

    /**
     * Determine if status code is "407 Proxy Authentication Required"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/407
     *
     * @return bool
     */
    public function isProxyAuthenticationRequired(): bool;

    /**
     * Determine if status code is "408 Request Timeout"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/408
     *
     * @return bool
     */
    public function isRequestTimeout(): bool;

    /**
     * Determine if status code is "409 Conflict"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/409
     *
     * @return bool
     */
    public function isConflict(): bool;

    /**
     * Determine if status code is "410 Gone"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/410
     *
     * @return bool
     */
    public function isGone(): bool;

    /**
     * Determine if status code is "411 Length Required"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/411
     *
     * @return bool
     */
    public function isLengthRequired(): bool;

    /**
     * Determine if status code is "412 Precondition Failed"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/412
     *
     * @return bool
     */
    public function isPreconditionFailed(): bool;

    /**
     * Determine if status code is "413 Payload Too Large"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/413
     *
     * @return bool
     */
    public function isPayloadTooLarge(): bool;

    /**
     * Determine if status code is "414 URI Too Long"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/414
     *
     * @return bool
     */
    public function isUriTooLong(): bool;

    /**
     * Determine if status code is "415 Unsupported Media Type"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/415
     *
     * @return bool
     */
    public function isUnsupportedMediaType(): bool;

    /**
     * Determine if status code is "416 Range Not Satisfiable"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/416
     *
     * @return bool
     */
    public function isRangeNotSatisfiable(): bool;

    /**
     * Determine if status code is "417 Expectation Failed"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/417
     *
     * @return bool
     */
    public function isExpectationFailed(): bool;

    /**
     * Determine if status code is "418 I'm a teapot" ;)
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/418
     *
     * @return bool
     */
    public function isTeapot(): bool;

    /**
     * Determine if status code is "421 Misdirected Request"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     *
     * @return bool
     */
    public function isMisdirectedRequest(): bool;

    /**
     * Determine if status code is "422 Unprocessable Entity"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/422
     *
     * @return bool
     */
    public function isUnprocessableEntity(): bool;

    /**
     * Determine if status code is "423 Locked"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     *
     * @return bool
     */
    public function isLocked(): bool;

    /**
     * Determine if status code is "424 Failed Dependency"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     *
     * @return bool
     */
    public function isFailedDependency(): bool;

    /**
     * Determine if status code is "425 Too Early"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/425
     *
     * @return bool
     */
    public function isTooEarly(): bool;

    /**
     * Determine if status code is "426 Upgrade Required"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/426
     *
     * @return bool
     */
    public function isUpgradeRequired(): bool;

    /**
     * Determine if status code is "428 Precondition Required"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/428
     *
     * @return bool
     */
    public function isPreconditionRequired(): bool;

    /**
     * Determine if status code is "429 Too Many Requests"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/429
     *
     * @return bool
     */
    public function isTooManyRequests(): bool;

    /**
     * Determine if status code is "431 Request Header Fields Too Large"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/431
     *
     * @return bool
     */
    public function isRequestHeaderFieldsTooLarge(): bool;

    /**
     * Determine if status code is "451 Unavailable For Legal Reasons"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/451
     *
     * @return bool
     */
    public function isUnavailableForLegalReasons(): bool;

    /*****************************************************************
     * 5xx Server Error
     ****************************************************************/

    /**
     * Determine if status code is "Server Error" (5xx)
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status#Server_error_responses
     *
     * @return bool
     */
    public function isServerError(): bool;

    /**
     * Determine if status code is "500 Internal Server Error"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/500
     *
     * @return bool
     */
    public function isInternalServerError(): bool;

    /**
     * Determine if status code is "501 Not Implemented"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/501
     *
     * @return bool
     */
    public function isNotImplemented(): bool;

    /**
     * Determine if status code is "502 Bad Gateway"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/502
     *
     * @return bool
     */
    public function isBadGateway(): bool;

    /**
     * Determine if status code is "503 Service Unavailable"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/503
     *
     * @return bool
     */
    public function isServiceUnavailable(): bool;

    /**
     * Determine if status code is "504 Gateway Timeout"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/504
     *
     * @return bool
     */
    public function isGatewayTimeout(): bool;

    /**
     * Determine if status code is "505 HTTP Version Not Supported"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/505
     *
     * @return bool
     */
    public function isHttpVersionNotSupported(): bool;

    /**
     * Determine if status code is "506 Variant Also Negotiates"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/506
     *
     * @return bool
     */
    public function isVariantAlsoNegotiates(): bool;

    /**
     * Determine if status code is "507 Insufficient Storage"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/507
     *
     * @return bool
     */
    public function isInsufficientStorage(): bool;

    /**
     * Determine if status code is "508 Loop Detected"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/508
     *
     * @return bool
     */
    public function isLoopDetected(): bool;

    /**
     * Determine if status code is "510 Not Extended"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/510
     *
     * @return bool
     */
    public function isNotExtended(): bool;

    /**
     * Determine if status code is "511 Network Authentication Required"
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/511
     *
     * @return bool
     */
    public function isNetworkAuthenticationRequired(): bool;

    /*****************************************************************
     * Misc.
     ****************************************************************/

    /**
     * Creates a new Http Status Code instance
     *
     * @param int $code Http status code
     * @param string $phrase [optional] Http status reason phrase. If none provided, then a phrase will be guessed.
     *
     * @return static
     *
     * @throws InvalidStatusCodeException
     */
    public static function make(int $code, string $phrase = ''): static;

    /**
     * Creates a new Http response status code instance from
     * the given request
     *
     * @param ResponseInterface $response
     *
     * @return static
     *
     * @throws InvalidStatusCodeException
     */
    public static function fromResponse(ResponseInterface $response): static;

    /**
     * Creates a new Http status code instance from given value
     *
     * @param mixed $value
     *
     * @return static
     *
     * @throws InvalidStatusCodeException
     */
    public static function from(mixed $value): static;

    /**
     * Guesses a reason phrase for given status code
     *
     * @param int $code
     *
     * @return string Empty if no reason phrase could be guessed for given status code
     */
    public static function guessPhrase(int $code): string;
}
