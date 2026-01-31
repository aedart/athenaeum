<?php

namespace Aedart\Tests\Unit\Utils\Concerns;

use Aedart\Contracts\Utils\HasDriverOptions;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Concerns\DriverOptions;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * DriverOptionsTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Utils\Concerns
 */
#[Group(
    'utils',
    'driver-options',
)]
class DriverOptionsTest extends UnitTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Makes a new "driver" instance with options
     *
     * @param  array  $options  [optional]
     *
     * @return HasDriverOptions
     */
    public function makeDriver(array $options = []): HasDriverOptions
    {
        $driver = new class() implements HasDriverOptions {
            use DriverOptions;

            public function __construct(array $options = [])
            {
                $this->setOptions($options);
            }
        };

        return new $driver($options);
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @return void
     */
    #[Test]
    public function canSetAndObtainOptions(): void
    {
        $options = [
            'alpha' => true,
            'beta' => false,
            'gamma' => true
        ];

        $driver = $this->makeDriver($options);

        $result = $driver->getOptions();

        $this->assertSame($options, $result);
    }

    /**
     * @return void
     */
    #[Test]
    public function canSetAndObtainValue(): void
    {
        $driver = $this->makeDriver();

        $key = 'alpha.beta.a';
        $value = 'pi';

        // ----------------------------------------------------------- //

        $driver->set($key, $value);
        $result = $driver->get($key);

        // ----------------------------------------------------------- //

        $this->assertTrue($driver->has($key), 'Key does not exist');
        $this->assertSame($value, $result);
    }

    /**
     * @return void
     */
    #[Test]
    public function canReturnsDefaultValue(): void
    {
        $driver = $this->makeDriver();

        $default = 'my_default_option_value';
        $result = $driver->get('unknown', $default);

        $this->assertSame($default, $result);
    }
}
