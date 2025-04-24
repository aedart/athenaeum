<?php


namespace Aedart\Tests\Integration\Circuits;

use Aedart\Contracts\Circuits\CircuitBreaker;
use Aedart\Contracts\Circuits\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\Circuits\Exceptions\ServiceUnavailableException;
use Aedart\Contracts\Circuits\Exceptions\UnknownStateException;
use Aedart\Tests\TestCases\Circuits\CircuitBreakerTestCase;
use Codeception\Attribute\Group;
use LogicException;
use PHPUnit\Framework\Attributes\Test;
use RuntimeException;

/**
 * CircuitBreakerTest
 *
 * @group circuits
 * @group circuit-breaker
 * @group circuit-breaker-instance
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Circuits
 */
#[Group(
    'circuits',
    'circuit-breaker',
    'circuit-breaker-instance',
)]
class CircuitBreakerTest extends CircuitBreakerTestCase
{
    /**
     * @test
     *
     * @throws ProfileNotFoundException
     */
    #[Test]
    public function returnsServiceName()
    {
        $service = 'my_service';
        $circuitBreaker = $this->makeCircuitBreaker($service);

        $this->assertSame($service, $circuitBreaker->name());
    }

    /**
     * @test
     *
     * @throws ProfileNotFoundException
     * @throws ServiceUnavailableException
     */
    #[Test]
    public function invokesCallback()
    {
        $callback = fn () => true;

        $circuitBreaker = $this->makeCircuitBreaker('my_service');
        $result = $circuitBreaker->attempt($callback);

        $this->assertTrue($result);
        $this->assertSame(CircuitBreaker::CLOSED, $circuitBreaker->state()->id(), 'Incorrect state');
    }

    /**
     * @test
     *
     * @throws ProfileNotFoundException
     * @throws ServiceUnavailableException
     */
    #[Test]
    public function failsWhenServiceIsUnavailable()
    {
        $this->expectException(ServiceUnavailableException::class);

        $callback = function () {
            throw new RuntimeException('Test Failure');
        };

        $circuitBreaker = $this->makeCircuitBreaker('my_service');
        $circuitBreaker->attempt($callback);
    }

    /**
     * @test
     *
     * @throws ProfileNotFoundException
     * @throws ServiceUnavailableException
     */
    #[Test]
    public function invokesOtherwiseCallbackWhenServiceUnavailable()
    {
        $callback = function () {
            throw new RuntimeException('Test Failure');
        };

        $otherwise = fn () => true;

        $circuitBreaker = $this->makeCircuitBreaker('my_service');
        $result = $circuitBreaker->attempt($callback, $otherwise);

        $this->assertTrue($result);
    }

    /**
     * @test
     *
     * @throws ProfileNotFoundException
     * @throws ServiceUnavailableException
     */
    #[Test]
    public function tripsWhenFailureThresholdReached()
    {
        $amount = 0;
        $callback = function () use (&$amount) {
            $amount++;
            throw new RuntimeException('Test Failure');
        };

        $circuitBreaker = $this->makeCircuitBreaker('my_service');

        try {
            $circuitBreaker
                ->retry(3, 0)
                ->withFailureThreshold(3)
                ->attempt($callback);
        } catch (ServiceUnavailableException $e) {
            // N/A - intended to fail...
        }

        // ---------------------------------------------- //

        $this->assertSame(3, $amount, 'Incorrect amount of attempts');
        $this->assertNotNull($circuitBreaker->lastFailure(), 'Should contain a last failure');
        $this->assertSame(CircuitBreaker::OPEN, $circuitBreaker->state()->id(), 'Should be "open"');
    }

    /**
     * @test
     *
     * @throws ProfileNotFoundException
     * @throws ServiceUnavailableException
     */
    #[Test]
    public function invokesOtherwiseCallbackWhenTripped()
    {
        $amount = 0;
        $callback = function () use (&$amount) {
            $amount++;
            throw new RuntimeException('Test Failure');
        };

        $otherwise = fn () => true;

        $result = $this->makeCircuitBreaker('my_service')
                ->retry(3, 0)
                ->withFailureThreshold(3)
                ->attempt($callback, $otherwise);

        $this->assertTrue($result, 'Otherwise callback not invoked');
        $this->assertSame(3, $amount, 'Incorrect amount of attempts');
    }

    /**
     * @test
     *
     * @throws ProfileNotFoundException
     * @throws ServiceUnavailableException
     */
    #[Test]
    public function invokesDefaultOtherwiseCallbackWhenServiceUnavailable()
    {
        $amount = 0;
        $callback = function () use (&$amount) {
            $amount++;
            throw new RuntimeException('Test Failure');
        };

        $otherwise = fn () => 'default_otherwise';

        $result = $this->makeCircuitBreaker('my_service')
            ->retry(3, 0)
            ->withFailureThreshold(3)
            ->otherwise($otherwise)
            ->attempt($callback);

        $this->assertSame('default_otherwise', $result, 'Otherwise callback not invoked');
        $this->assertSame(3, $amount, 'Incorrect amount of attempts');
    }

    /**
     * @test
     *
     * @throws ProfileNotFoundException
     * @throws ServiceUnavailableException
     * @throws UnknownStateException
     */
    #[Test]
    public function failsFastWhenStateIsOpen()
    {
        $callback = function () {
            throw new RuntimeException('Test failure');
        };
        $otherwise = fn () => true;

        $circuitBreaker = $this->makeCircuitBreaker('my_service')
            ->retry(1, 0)
            ->withFailureThreshold(1);

        $resultA = $circuitBreaker->attempt($callback, $otherwise);
        $resultB = $circuitBreaker->attempt($callback, $otherwise);

        $this->assertTrue($resultA);
        $this->assertTrue($resultB, 'Otherwise not invoked 2nd time!');
    }

    /**
     * @test
     *
     * @throws ProfileNotFoundException
     * @throws ServiceUnavailableException
     */
    #[Test]
    public function attemptsCallbackWhenGracePeriodHasPast()
    {
        $circuitBreaker = $this->makeCircuitBreaker('my_service')
            ->retry(1, 0)
            ->withFailureThreshold(1)
            ->withGracePeriod(0);

        $circuitBreaker->attempt(function () {
            throw new RuntimeException('Test failure');
        }, fn () => false);

        // ---------------------------------------------------- //
        // Circuit Breaker attempt to change state to "half-open"
        // after a grace period has past.

        $result = $circuitBreaker->attempt(function (CircuitBreaker $circuitBreaker) {
            // State SHOULD be changed to half-open
            if (!$circuitBreaker->isHalfOpen()) {
                throw new LogicException(sprintf(
                    'State was expected to be "half-open"; %s given',
                    $circuitBreaker->state()->name()
                ));
            }

            return true;
        });

        // ---------------------------------------------------- //
        // State SHOULD now be closed again, due to successful attempt,
        // after grace period has past (intermediate half-open state).
        // In short: service was recovered...

        $this->assertTrue($result);
        $this->assertSame(CircuitBreaker::CLOSED, $circuitBreaker->state()->id(), 'Failed to change state after half-open');
    }
}
