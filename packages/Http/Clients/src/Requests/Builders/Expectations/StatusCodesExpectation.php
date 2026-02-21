<?php

namespace Aedart\Http\Clients\Requests\Builders\Expectations;

use Aedart\Contracts\Http\Clients\Exceptions\ExpectationNotMetException;
use Aedart\Contracts\Http\Clients\Responses\Status;
use Aedart\Http\Clients\Exceptions\ExpectationNotMet;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Http Status Codes Expectation
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Expectations
 */
class StatusCodesExpectation extends ResponseExpectation
{
    /**
     * The expected http status codes
     *
     * @var int[]
     */
    protected array $expectedStatusCodes = [];

    /**
     * Otherwise handler
     *
     * @var callable(Status $status, ResponseInterface $response, RequestInterface $request): (void)|null
     */
    protected $otherwise = null;

    /**
     * StatusCodesExpectation constructor.
     *
     * @param int|int[] $expectedStatusCodes The http status code(s) that are expected
     * @param callable(Status $status, ResponseInterface $response, RequestInterface $request): (void)|null $otherwise [optional] Callback to be invoked when received http status code does not
     *                                 match either of the expected codes.
     */
    public function __construct($expectedStatusCodes, callable|null $otherwise = null)
    {
        parent::__construct();

        $this
            ->setExpectedStatusCodes($expectedStatusCodes)
            ->setOtherwise($otherwise);
    }

    /**
     * Set the expected http status codes.
     *
     * If the received response's status code matches one of
     * the given status codes, then the expectation is met.
     *
     * @param int|int[] $codes
     *
     * @return self
     */
    public function setExpectedStatusCodes(array|int $codes): static
    {
        if (!is_array($codes)) {
            $codes = [$codes];
        }

        $this->expectedStatusCodes = $codes;

        return $this;
    }

    /**
     * Set otherwise handler, to be invoked is response's
     * status code didn't meet expectation
     *
     * @param callable(Status $status, ResponseInterface $response, RequestInterface $request): (void)|null $otherwise  [optional]
     *
     * @return self
     */
    public function setOtherwise(callable|null $otherwise = null): static
    {
        $this->otherwise = $otherwise;

        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * Matches the expected http status codes against received response's http status code.
     *
     * Method aborts - does nothing - if there is a match. If not there is no match, then
     * this method will apply given callback, set via {@see setOtherwise}.
     *
     * If no callback is provided, then this method will build a default callback that
     * throws {@see ExpectationNotMetException}.
     */
    public function expectation(Status $status, ResponseInterface $response, RequestInterface $request): void
    {
        // Abort if the http status code matches expected
        if ($status->satisfies($this->expectedStatusCodes)) {
            return;
        }

        // This means that expectation has not been met. We must therefore resolve a "failure", exception
        // or "failure" handler.
        $callback = $this->resolveOtherwiseCallback();

        // Invoke the callback, with the provided arguments.
        // This callback is expected to throw an exception, but not strictly required...
        $callback($status, $response, $request);
    }

    /**
     * Default method to be invoked, if no {@see otherwise} callback has been provided
     *
     * @param  Status  $status
     * @param  ResponseInterface  $response
     * @param  RequestInterface  $request
     *
     * @throws ExpectationNotMetException
     */
    public function defaultOtherwise(Status $status, ResponseInterface $response, RequestInterface $request): void
    {
        // Make a default "reason" message
        $expectedStatusCodes = implode('or ', $this->expectedStatusCodes);
        $receivedStatusCode = (string) $status;

        $reason = sprintf('Received http status %s, but expected: %s', $receivedStatusCode, $expectedStatusCodes);

        // Create default exception and throw it
        throw ExpectationNotMet::make(
            $reason,
            $status,
            $response,
            $request
        );
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Returns the otherwise callback that has been set or
     * builds a default callback
     *
     * @see setOtherwise
     * @see buildDefaultOtherwiseCallback
     *
     * @return callable(Status $status, ResponseInterface $response, RequestInterface $request): void
     */
    protected function resolveOtherwiseCallback(): callable
    {
        return $this->otherwise ?? [$this, 'defaultOtherwise'];
    }
}
