<?php

namespace Aedart\Http\Clients\Requests\Builders\Concerns;

use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Contracts\Http\Clients\Responses\ResponseExpectation as ResponseExpectationInterface;
use Aedart\Contracts\Http\Clients\Responses\Status;
use Aedart\Http\Clients\Requests\Builders\Expectations\ResponseExpectation;
use Aedart\Http\Clients\Requests\Builders\Expectations\StatusCodesExpectation;
use InvalidArgumentException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

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
    public function expect(callable|array|int|ResponseExpectationInterface $status, callable|null $otherwise = null): static
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
    public function withExpectation(callable|ResponseExpectationInterface $expectation): static
    {
        $this->expectations[] = $this->resolveExpectation($expectation);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function withExpectations(array $expectations = []): static
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
     * Resolve given response expectation
     *
     * @param  callable(Status $status, ResponseInterface $response, RequestInterface $request): (void)|ResponseExpectationInterface  $callback
     *
     * @return ResponseExpectationInterface
     */
    protected function resolveExpectation(callable|ResponseExpectationInterface $callback): ResponseExpectationInterface
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
