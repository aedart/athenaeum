<?php

namespace Aedart\Http\Clients\Requests\Builders\Concerns;

use Aedart\Contracts\Http\Clients\Exceptions\InvalidStatusCodeException;
use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Contracts\Http\Clients\Responses\Status;
use Aedart\Http\Clients\Responses\ResponseStatus;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Concerns Response Expectations
 *
 * @see Builder
 * @see Builder::withExpectation
 * @see Builder::withExpectations
 * @see Builder::hasExpectations
 * @see Builder::getExpectations
 * @see Builder::expect
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Concerns
 */
trait ResponseExpectations
{
    /**
     * Response Expectations
     *
     * @var callable[]
     */
    protected array $expectations = [];

    /**
     * @inheritdoc
     */
    public function withExpectation(callable $expectation): Builder
    {
        $this->expectations[] = $expectation;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function withExpectations(array $expectations = []): Builder
    {
        foreach ($expectations as $expectation) {
            $this->withExpectation($expectation);
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function hasExpectations(): bool
    {
        return !empty($this->expectations);
    }

    /**
     * @inheritdoc
     */
    public function getExpectations(): array
    {
        return $this->expectations;
    }

    /**
     * @inheritdoc
     */
    public function expect($status, $otherwise = null): Builder
    {
        // TODO: Implement expect() method.
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Apply the registered response expectations
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return Builder
     *
     * @throws Throwable
     */
    protected function applyExpectations(RequestInterface $request, ResponseInterface $response): Builder
    {
        if (!$this->hasExpectations()) {
            return $this;
        }

        $expectations = $this->getExpectations();
        $status = $this->makeResponseStatus($response);

        foreach ($expectations as $expectation) {
            $this->invokeExpectationCallback($expectation, $request, $response, $status);
        }

        return $this;
    }

    /**
     * Invokes the given expectation callback
     *
     * @param callable $callback
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param Status $status
     *
     * @throws Throwable
     */
    protected function invokeExpectationCallback(
        callable $callback,
        RequestInterface $request,
        ResponseInterface $response,
        Status $status
    ): void {
        // Invoke the callback, with the status, response and request, in mentioned
        // order. Hopefully that order is the most convenient way to deal with them.
        $callback($status, $response, $request);
    }

    /**
     * Creates a new Http Response Status instance from given response
     *
     * @param ResponseInterface $response
     * @return Status
     *
     * @throws InvalidStatusCodeException
     */
    protected function makeResponseStatus(ResponseInterface $response): Status
    {
        return ResponseStatus::fromResponse($response);
    }
}
