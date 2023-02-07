<?php

namespace Aedart\Http\Clients\Responses;

use Aedart\Contracts\Http\Clients\Exceptions\InvalidStatusCodeException;
use Aedart\Contracts\Http\Clients\Responses\Status;
use Aedart\Http\Clients\Exceptions\InvalidStatusCode;
use Psr\Http\Message\ResponseInterface;

/**
 * Http Response Status
 *
 * @see \Aedart\Contracts\Http\Clients\Responses\Status
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Responses
 */
class ResponseStatus implements Status
{
    /**
     * Http Response status reason phrases
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     *
     * @var string[]
     */
    protected static array $phrases = [
        // Informational (100 – 199)
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        103 => 'Early Hints',

        // Successful (200 – 299)
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',
        208 => 'Already Reported',
        226 => 'IM Used',

        // Redirection (300 – 399)
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',

        // Client error (400 – 499)
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Content Too Large',
        414 => 'URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        421 => 'Misdirected Request',
        422 => 'Unprocessable Content',
        423 => 'Locked',
        424 => 'Failed Dependency',
        425 => 'Too Early',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        451 => 'Unavailable For Legal Reasons',

        // Server error (500 – 599)
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        510 => 'Not Extended',
        511 => 'Network Authentication Required',
    ];

    /**
     * Create a new Http Status instance
     *
     * @param int $code Http status code
     * @param string $phrase [optional] Http status reason phrase. If none provided, then a phrase will be guessed.
     *
     * @throws InvalidStatusCodeException
     */
    public function __construct(
        protected readonly int $code,
        protected string $phrase = ''
    ) {
        if ($code < 100 || $code > 599) {
            throw new InvalidStatusCode(sprintf('Must be a valid Http Response code. Status %s given', $code));
        }

        if (empty($this->phrase)) {
            $this->phrase = static::guessPhrase($this->code);
        }
    }

    /**
     * @inheritDoc
     */
    public function code(): int
    {
        return $this->code;
    }

    /**
     * @inheritDoc
     */
    public function phrase(): string
    {
        return $this->phrase;
    }

    /*****************************************************************
     * Compare methods
     ****************************************************************/

    /**
     * @inheritDoc
     */
    public function is(int $expectedCode): bool
    {
        return $this->code() === $expectedCode;
    }

    /**
     * @inheritDoc
     */
    public function matches(int|Status $status): bool
    {
        $code = $status instanceof Status
            ? $status->code()
            : $status;

        return $this->is($code);
    }

    /**
     * @inheritDoc
     */
    public function satisfies(array|int|Status $status): bool
    {
        if (!is_array($status)) {
            $status = [ $status ];
        }

        foreach ($status as $code) {
            if ($this->matches($code)) {
                return true;
            }
        }

        return false;
    }

    /*****************************************************************
     * 1xx Informational
     ****************************************************************/

    /**
     * @inheritDoc
     */
    public function isInformational(): bool
    {
        $code = $this->code();

        return $code >= 100 && $code < 200;
    }

    /**
     * @inheritDoc
     */
    public function isContinue(): bool
    {
        return $this->is(100);
    }

    /**
     * @inheritDoc
     */
    public function isSwitchingProtocols(): bool
    {
        return $this->is(101);
    }

    /**
     * @inheritDoc
     */
    public function isProcessing(): bool
    {
        return $this->is(102);
    }

    /**
     * @inheritDoc
     */
    public function isEarlyHints(): bool
    {
        return $this->is(103);
    }

    /*****************************************************************
     * 2xx Successful
     ****************************************************************/

    /**
     * @inheritDoc
     */
    public function isSuccessful(): bool
    {
        $code = $this->code();

        return $code >= 200 && $code < 300;
    }

    /**
     * @inheritDoc
     */
    public function isOk(): bool
    {
        return $this->is(200);
    }

    /**
     * @inheritDoc
     */
    public function isCreated(): bool
    {
        return $this->is(201);
    }

    /**
     * @inheritDoc
     */
    public function isAccepted(): bool
    {
        return $this->is(202);
    }

    /**
     * @inheritDoc
     */
    public function isNonAuthoritativeInformation(): bool
    {
        return $this->is(203);
    }

    /**
     * @inheritDoc
     */
    public function isNoContent(): bool
    {
        return $this->is(204);
    }

    /**
     * @inheritDoc
     */
    public function isResetContent(): bool
    {
        return $this->is(205);
    }

    /**
     * @inheritDoc
     */
    public function isPartialContent(): bool
    {
        return $this->is(206);
    }

    /**
     * @inheritDoc
     */
    public function isMultiStatus(): bool
    {
        return $this->is(207);
    }

    /**
     * @inheritDoc
     */
    public function isAlreadyReported(): bool
    {
        return $this->is(208);
    }

    /**
     * @inheritDoc
     */
    public function isImUsed(): bool
    {
        return $this->is(226);
    }

    /*****************************************************************
     * 3xx Redirection
     ****************************************************************/

    /**
     * @inheritDoc
     */
    public function isRedirection(): bool
    {
        $code = $this->code();

        return $code >= 300 && $code < 400;
    }

    /**
     * @inheritDoc
     */
    public function isMultipleChoices(): bool
    {
        return $this->is(300);
    }

    /**
     * @inheritDoc
     */
    public function isMovedPermanently(): bool
    {
        return $this->is(301);
    }

    /**
     * @inheritDoc
     */
    public function isFound(): bool
    {
        return $this->is(302);
    }

    /**
     * @inheritDoc
     */
    public function isSeeOther(): bool
    {
        return $this->is(303);
    }

    /**
     * @inheritDoc
     */
    public function isNotModified(): bool
    {
        return $this->is(304);
    }

    /**
     * @inheritDoc
     */
    public function isTemporaryRedirect(): bool
    {
        return $this->is(307);
    }

    /**
     * @inheritDoc
     */
    public function isPermanentRedirect(): bool
    {
        return $this->is(308);
    }

    /*****************************************************************
     * 4xx Client Error
     ****************************************************************/

    /**
     * @inheritDoc
     */
    public function isClientError(): bool
    {
        $code = $this->code();

        return $code >= 400 && $code < 500;
    }

    /**
     * @inheritDoc
     */
    public function isBadRequest(): bool
    {
        return $this->is(400);
    }

    /**
     * @inheritDoc
     */
    public function isUnauthorized(): bool
    {
        return $this->is(401);
    }

    /**
     * @inheritDoc
     */
    public function isPaymentRequired(): bool
    {
        return $this->is(402);
    }

    /**
     * @inheritDoc
     */
    public function isForbidden(): bool
    {
        return $this->is(403);
    }

    /**
     * @inheritDoc
     */
    public function isNotFound(): bool
    {
        return $this->is(404);
    }

    /**
     * @inheritDoc
     */
    public function isMethodNotAllowed(): bool
    {
        return $this->is(405);
    }

    /**
     * @inheritDoc
     */
    public function isNotAcceptable(): bool
    {
        return $this->is(406);
    }

    /**
     * @inheritDoc
     */
    public function isProxyAuthenticationRequired(): bool
    {
        return $this->is(407);
    }

    /**
     * @inheritDoc
     */
    public function isRequestTimeout(): bool
    {
        return $this->is(408);
    }

    /**
     * @inheritDoc
     */
    public function isConflict(): bool
    {
        return $this->is(409);
    }

    /**
     * @inheritDoc
     */
    public function isGone(): bool
    {
        return $this->is(410);
    }

    /**
     * @inheritDoc
     */
    public function isLengthRequired(): bool
    {
        return $this->is(411);
    }

    /**
     * @inheritDoc
     */
    public function isPreconditionFailed(): bool
    {
        return $this->is(412);
    }

    /**
     * @inheritDoc
     */
    public function isPayloadTooLarge(): bool
    {
        return $this->is(413);
    }

    /**
     * @inheritDoc
     */
    public function isUriTooLong(): bool
    {
        return $this->is(414);
    }

    /**
     * @inheritDoc
     */
    public function isUnsupportedMediaType(): bool
    {
        return $this->is(415);
    }

    /**
     * @inheritDoc
     */
    public function isRangeNotSatisfiable(): bool
    {
        return $this->is(416);
    }

    /**
     * @inheritDoc
     */
    public function isExpectationFailed(): bool
    {
        return $this->is(417);
    }

    /**
     * @inheritDoc
     */
    public function isTeapot(): bool
    {
        return $this->is(418);
    }

    /**
     * @inheritDoc
     */
    public function isMisdirectedRequest(): bool
    {
        return $this->is(421);
    }

    /**
     * @inheritDoc
     */
    public function isUnprocessableEntity(): bool
    {
        return $this->is(422);
    }

    /**
     * @inheritDoc
     */
    public function isLocked(): bool
    {
        return $this->is(423);
    }

    /**
     * @inheritDoc
     */
    public function isFailedDependency(): bool
    {
        return $this->is(424);
    }

    /**
     * @inheritDoc
     */
    public function isTooEarly(): bool
    {
        return $this->is(425);
    }

    /**
     * @inheritDoc
     */
    public function isUpgradeRequired(): bool
    {
        return $this->is(426);
    }

    /**
     * @inheritDoc
     */
    public function isPreconditionRequired(): bool
    {
        return $this->is(428);
    }

    /**
     * @inheritDoc
     */
    public function isTooManyRequests(): bool
    {
        return $this->is(429);
    }

    /**
     * @inheritDoc
     */
    public function isRequestHeaderFieldsTooLarge(): bool
    {
        return $this->is(431);
    }

    /**
     * @inheritDoc
     */
    public function isUnavailableForLegalReasons(): bool
    {
        return $this->is(451);
    }

    /*****************************************************************
     * 5xx Server Error
     ****************************************************************/

    /**
     * @inheritDoc
     */
    public function isServerError(): bool
    {
        $code = $this->code();

        return $code >= 500 && $code < 600;
    }

    /**
     * @inheritDoc
     */
    public function isInternalServerError(): bool
    {
        return $this->is(500);
    }

    /**
     * @inheritDoc
     */
    public function isNotImplemented(): bool
    {
        return $this->is(501);
    }

    /**
     * @inheritDoc
     */
    public function isBadGateway(): bool
    {
        return $this->is(502);
    }

    /**
     * @inheritDoc
     */
    public function isServiceUnavailable(): bool
    {
        return $this->is(503);
    }

    /**
     * @inheritDoc
     */
    public function isGatewayTimeout(): bool
    {
        return $this->is(504);
    }

    /**
     * @inheritDoc
     */
    public function isHttpVersionNotSupported(): bool
    {
        return $this->is(505);
    }

    /**
     * @inheritDoc
     */
    public function isVariantAlsoNegotiates(): bool
    {
        return $this->is(506);
    }

    /**
     * @inheritDoc
     */
    public function isInsufficientStorage(): bool
    {
        return $this->is(507);
    }

    /**
     * @inheritDoc
     */
    public function isLoopDetected(): bool
    {
        return $this->is(508);
    }

    /**
     * @inheritDoc
     */
    public function isNotExtended(): bool
    {
        return $this->is(510);
    }

    /**
     * @inheritDoc
     */
    public function isNetworkAuthenticationRequired(): bool
    {
        return $this->is(511);
    }

    /*****************************************************************
     * Misc.
     ****************************************************************/

    /**
     * @inheritDoc
     */
    public static function make(int $code, string $phrase = ''): static
    {
        return new static($code, $phrase);
    }

    /**
     * @inheritDoc
     */
    public static function fromResponse(ResponseInterface $response): static
    {
        return static::make(
            $response->getStatusCode(),
            $response->getReasonPhrase()
        );
    }

    /**
     * @inheritDoc
     */
    public static function from(mixed $value): static
    {
        return match (true) {
            is_numeric($value) => static::make((int) $value),
            $value instanceof ResponseInterface => static::fromResponse($value),

            // Symfony / Laravel Response
            is_object($value) && method_exists($value, 'getStatusCode') => static::make(code: $value->getStatusCode()),

            default => throw new InvalidStatusCode(sprintf('Unable to create Http Status instance from given value type: %s', gettype($value)))
        };
    }

    /**
     * @inheritDoc
     */
    public static function guessPhrase(int $code): string
    {
        return static::$phrases[$code] ?? '';
    }

    /**
     * Returns the Http Response status as a string
     *
     * @return string
     */
    public function __toString(): string
    {
        $code = $this->code();
        $phrase = $this->phrase();

        return "{$code} {$phrase}";
    }
}
