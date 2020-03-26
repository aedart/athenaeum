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
     * Response Http status code
     *
     * @var int
     */
    protected int $code;

    /**
     * Response Http status reason phrase
     *
     * @var string
     */
    protected string $phrase;

    /**
     * ResponseStatus constructor.
     *
     * @param int $code
     * @param string $phrase [optional]
     *
     * @throws InvalidStatusCodeException
     */
    public function __construct(int $code, string $phrase = '')
    {
        if (!is_numeric($code) || (int) $code < 100) {
            throw new InvalidStatusCode(sprintf('Must be a valid Http Response code. %s given', $code));
        }

        $this->code = $code;
        $this->phrase = $phrase;
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
    public function isSuccessful(): bool
    {
        $code = $this->code();

        return $code >= 200 && $code < 300;
    }

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
    public function isClientError(): bool
    {
        $code = $this->code();

        return $code >= 400 && $code < 500;
    }

    /**
     * @inheritDoc
     */
    public function isServerError(): bool
    {
        return $this->code() >= 500;
    }

    /**
     * @inheritDoc
     */
    public static function fromResponse(ResponseInterface $response): Status
    {
        return new static(
            $response->getStatusCode(),
            $response->getReasonPhrase()
        );
    }
}
