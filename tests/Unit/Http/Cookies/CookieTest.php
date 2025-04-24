<?php

namespace Aedart\Tests\Unit\Http\Cookies;

use Aedart\Contracts\Http\Cookies\Cookie as CookieInterface;
use Aedart\Http\Cookies\Cookie;
use Aedart\Testing\TestCases\UnitTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;
use Throwable;

/**
 * CookieTest
 *
 * @group http-cookies
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Http\Cookies
 */
#[Group(
    'http-cookies',
)]
class CookieTest extends UnitTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Creates a new Cookie instance
     *
     * @param array $data [optional]
     *
     * @return CookieInterface
     *
     * @throws Throwable
     */
    protected function makeCookie(array $data = []): CookieInterface
    {
        return new Cookie($data);
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     *
     * @throws Throwable
     */
    #[Test]
    public function canPopulate()
    {
        $name = 'token';
        $value = $this->getFaker()->sha1();

        $cookie = $this->makeCookie([
            'name' => $name,
            'value' => $value
        ]);

        $this->assertSame($name, $cookie->getName(), 'Incorrect name');
        $this->assertSame($value, $cookie->getValue(), 'Incorrect value');
    }

    /**
     * @test
     *
     * @throws Throwable
     */
    #[Test]
    public function canExportToArray()
    {
        $name = 'token';
        $value = $this->getFaker()->sha1();

        $cookie = $this->makeCookie([
            'name' => $name,
            'value' => $value
        ]);

        $this->assertSame([
            'name' => $name,
            'value' => $value
        ], $cookie->toArray());
    }
}
