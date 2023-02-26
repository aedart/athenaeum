<?php

namespace Aedart\Contracts\Utils;

/**
 * Has Mockable Driver
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Utils
 */
interface HasMockableDriver extends HasDriver
{
    /**
     * Mocks the native driver
     *
     * @param mixed ...$args Native driver to mock
     *
     * @return \Mockery\MockInterface
     */
    public function mockDriver(...$args);

    /**
     * Makes the native driver to a mockery spy
     *
     * @see http://docs.mockery.io/en/latest/reference/spies.html
     *
     * @param mixed ...$args Native driver to mock
     *
     * @return \Mockery\MockInterface
     */
    public function spyDriver(...$args);

    /**
     * Partially mock the native driver
     *
     * @see http://docs.mockery.io/en/latest/reference/partial_mocks.html
     *
     * @param mixed ...$args Native driver to mock partially
     *
     * @return \Mockery\MockInterface
     */
    public function partialMockDriver(...$args);

    /**
     * Determine if native driver is mocked
     *
     * @return bool
     */
    public function isDriverMocked(): bool;
}
