<?php

namespace Aedart\Http\Clients\Exceptions;

use Aedart\Contracts\Http\Clients\Exceptions\ExpectationNotMetException;
use Aedart\Contracts\Http\Clients\Requests\Builders\Expectations\ExpectationNotFulfilled;
use Aedart\Contracts\Http\Clients\Responses\Status;
use Aedart\Http\Clients\Requests\Builders\Expectations\ExpectationNotFulfilled as Expectation;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;
use Throwable;

/**
 * Response Expectation Not Met Exception
 *
 * @see \Aedart\Contracts\Http\Clients\Exceptions\ExpectationNotMetException
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Exceptions
 */
class ExpectationNotMet extends RuntimeException implements ExpectationNotMetException
{
    /**
     * Details about why expectation was not met
     *
     * @var ExpectationNotFulfilled
     */
    protected ExpectationNotFulfilled $expectation;

    /**
     * ExpectationNotMet constructor.
     *
     * @param ExpectationNotFulfilled $expectation
     * @param string $message [optional] Defaults to reason stated in {@see ExpectationNotFulfilled}, if not given.
     * @param int $code [optional]
     * @param Throwable|null $previous [optional]
     */
    public function __construct(
        ExpectationNotFulfilled $expectation,
        string $message = "",
        int $code = 0,
        Throwable|null $previous = null
    ) {
        $this->expectation = $expectation;

        if (empty($message)) {
            $message = $expectation->reason();
        }

        parent::__construct($message, $code, $previous);
    }

    /**
     * Create a new instance
     *
     * @param string $reason
     * @param Status $status
     * @param ResponseInterface $response
     * @param RequestInterface $request
     *
     * @return static
     */
    public static function make(
        string $reason,
        Status $status,
        ResponseInterface $response,
        RequestInterface $request
    ): ExpectationNotMetException {
        // Create a new expectation from arguments
        $expectation = new Expectation($reason, $status, $response, $request);

        // Create new exception instance
        return new static($expectation);
    }

    /**
     * @inheritDoc
     */
    public function getExpectation(): ExpectationNotFulfilled
    {
        return $this->expectation;
    }

    /**
     * @inheritDoc
     */
    public function getStatus(): Status
    {
        return $this->getExpectation()->status();
    }

    /**
     * @inheritDoc
     */
    public function getReason(): string
    {
        return $this->getExpectation()->reason();
    }

    /**
     * @inheritDoc
     */
    public function getResponse(): ResponseInterface
    {
        return $this->getExpectation()->response();
    }

    /**
     * @inheritDoc
     */
    public function getRequest(): RequestInterface|null
    {
        return $this->getExpectation()->request();
    }
}
