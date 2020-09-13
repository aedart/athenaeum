<?php

namespace Aedart\Http\Clients\Requests\Builders\Concerns;

use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Contracts\Http\Clients\Responses\ResponseExpectation as ResponseExpectationInterface;
use Aedart\Http\Clients\Requests\Builders\Expectations\ResponseExpectation;
use Aedart\Http\Clients\Requests\Builders\Expectations\StatusCodesExpectation;
use InvalidArgumentException;
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
    use ResponseStatus;

    /**
     * Response Expectations
     *
     * @var ResponseExpectationInterface[]
     */
    protected array $expectations = [];

    /**
     * @inheritdoc
     */
    public function expect($status, ?callable $otherwise = null): Builder
    {
        if (is_callable($status) || $status instanceof ResponseExpectationInterface) {
            return $this->withExpectation($status);
        }

        return $this->withExpectation(
            new StatusCodesExpectation($status, $otherwise)
        );
    }

    /**
     * @inheritdoc
     */
    public function withExpectation($expectation): Builder
    {
        $this->expectations[] = $this->resolveExpectation($expectation);

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

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Apply the registered response expectations
     *
     * @param  RequestInterface  $request
     * @param  ResponseInterface  $response
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
        foreach ($expectations as $expectation) {
            $expectation->apply($request, $response);
        }

        return $this;
    }

    /**
     * Resolve given response expectation
     *
     * @param  callable|ResponseExpectationInterface  $callback
     *
     * @return ResponseExpectationInterface
     */
    protected function resolveExpectation($callback): ResponseExpectationInterface
    {
        if ($callback instanceof ResponseExpectationInterface) {
            return $callback;
        }

        if (is_callable($callback)) {
            return new ResponseExpectation($callback);
        }

        throw new InvalidArgumentException('Response Expectation must be a valid callable or instance of "ResponseExpectation"');
    }
}
