<?php

namespace Aedart\Tests\Unit\Utils\Concerns;

use Aedart\Contracts\Utils\HasMockableDriver;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Tests\Helpers\Dummies\Box;
use Aedart\Tests\Helpers\Dummies\Contracts\Box as BoxInterface;
use Aedart\Utils\Concerns\MockableDriver;
use Codeception\Attribute\Group;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;

/**
 * MockableDriverTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Utils\Concerns
 */
#[Group(
    'utils',
    'driver',
    'mockable-driver',
)]
class MockableDriverTest extends UnitTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Makes a new component with a "driver"
     *
     * @return HasMockableDriver
     */
    public function makeComponent(): HasMockableDriver
    {
        $driver = new class() implements HasMockableDriver {
            use MockableDriver;

            protected function makeDriver(): BoxInterface
            {
                return new Box();
            }

            public function setWidth(int $value): static
            {
                $this->driver()->setWidth($value);

                return $this;
            }

            public function getWidth(): mixed
            {
                return $this->driver()->getWidth();
            }
        };

        return new $driver();
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @return void
     */
    #[Test]
    public function returnsNativeDriverWhenNotMocked(): void
    {
        $component = $this->makeComponent();

        $driver = $component->driver();

        $this->assertNotNull($driver);
        $this->assertFalse($component->isDriverMocked(), 'native driver should not be mocked');
    }

    /**
     * @return void
     */
    #[Test]
    public function canMockNativeDriver(): void
    {
        $expected = 123;

        $component = $this->makeComponent();
        $component
            ->mockDriver(BoxInterface::class)
            ->shouldReceive([
                'getWidth' => $expected
            ]);

        $result = $component->driver()->getWidth();

        $this->assertSame($expected, $result);
        $this->assertTrue($component->isDriverMocked(), 'native driver should be mocked');
    }

    /**
     * @return void
     */
    #[Test]
    public function canPartiallyMockNativeDriver(): void
    {
        $expected = 123;

        $component = $this->makeComponent();
        $component
            ->partialMockDriver(Box::class)
            ->shouldReceive([
                'getWidth' => $expected
            ]);

        $result = $component
            ->setWidth(3214)
            ->getWidth();

        $this->assertSame($expected, $result);
        $this->assertTrue($component->isDriverMocked(), 'native driver should be mocked');
    }

    /**
     * @return void
     */
    #[Test]
    public function canSpyMockNativeDriver(): void
    {
        $expected = 123;

        $component = $this->makeComponent();
        /** @var BoxInterface|MockInterface $driver */
        $driver = $component
            ->spyDriver(Box::class);

        // Call set width on driver...
        $component->setWidth($expected);

        // Expect what should have been called...
        $driver
            ->shouldHaveReceived('setWidth')
            ->with($expected);

        $this->assertTrue($component->isDriverMocked(), 'native driver should be mocked');
    }
}
