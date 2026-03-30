<?php

namespace Aedart\Http\Clients\Requests\Builders\Expectations;

use Aedart\Contracts\Http\Clients\Responses\ResponseExpectation as ResponseExpectationInterface;
use Aedart\Contracts\Http\Clients\Responses\Status;
use Aedart\Http\Clients\Requests\Builders\Concerns;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Response Expectation
 *
 * @see \Aedart\Contracts\Http\Clients\Responses\ResponseExpectation
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Expectations
 */
class ResponseExpectation implements ResponseExpectationInterface
{
    use Concerns\ResponseStatus;

    /**
     * The expectation callback
     *
     * @var callable(Status $status, ResponseInterface $response, RequestInterface $request): void
     */
    protected $expectationCallback;

    /**
     * ResponseExpectation constructor.
     *
     * @param  callable(Status $status, ResponseInterface $response, RequestInterface $request): (void)|null  $callback  [optional]
     */
    public function __construct(callable|null $callback = null)
    {
        if (isset($callback)) {
            $this->expect($callback);
        }
    }

    /**
     * @inheritdoc
     */
    public function expect(callable $expectation): static
    {
        $this->expectationCallback = $expectation;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getExpectation(): callable
    {
        return $this->expectationCallback ?? [$this, 'expectation'];
    }

    /**
     * @inheritdoc
     */
    public function expectation(
        Status $status,
        ResponseInterface $response,
        RequestInterface $request
    ): void {
        // Overwrite this method to create response expectation
    }

    /**
     * @inheritdoc
     */
    public function apply(RequestInterface $request, ResponseInterface $response): void
    {
        // Resolve status and expectation callback.
        $status = $this->makeResponseStatus($response);
        $callback = $this->getExpectation();

        // Invoke the callback, with the status, response and request, in mentioned
        // order. Hopefully that order is the most convenient way to deal with them.
        $callback($status, $response, $request);
    }
}
