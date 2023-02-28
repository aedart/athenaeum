<?php

namespace Aedart\Utils\Concerns;

use Mockery;
use Mockery\MockInterface;

/**
 * Concerns Mockable Driver
 *
 * @see \Aedart\Contracts\Utils\HasMockableDriver
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Utils\Concerns
 */
trait MockableDriver
{
    use Driver;

    /**
     * Mocks the native driver
     *
     * @param mixed ...$args Native driver to mock
     *
     * @return MockInterface
     */
    public function mockDriver(...$args)
    {
        $mock = Mockery::mock(...$args)
            ->shouldAllowMockingProtectedMethods();

        return $this->swapDriver($mock);
    }

    /**
     * Makes the native driver to a mockery spy
     *
     * @see http://docs.mockery.io/en/latest/reference/spies.html
     *
     * @param mixed ...$args Native driver to mock
     *
     * @return MockInterface
     */
    public function spyDriver(...$args)
    {
        $spy = Mockery::spy(...$args);

        return $this->swapDriver($spy);
    }

    /**
     * Partially mock the native driver
     *
     * @see http://docs.mockery.io/en/latest/reference/partial_mocks.html
     *
     * @param mixed ...$args Native driver to mock partially
     *
     * @return MockInterface
     */
    public function partialMockDriver(...$args)
    {
        $driver = $this->isDriverMocked()
            ? $this->driver()
            : $this->mockDriver(...$args);

        return $driver->makePartial();
    }

    /**
     * Determine if native driver is mocked
     *
     * @return bool
     */
    public function isDriverMocked(): bool
    {
        return $this->hasDriver() && $this->driver instanceof MockInterface;
    }
}
