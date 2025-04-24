<?php

namespace Aedart\Tests\Unit\Http\Cookies;

use Aedart\Contracts\Http\Cookies\SetCookie as SetCookieInterface;
use Aedart\Http\Cookies\SetCookie;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Codeception\Attribute\Group;
use DateTime;
use PHPUnit\Framework\Attributes\Test;
use Throwable;

/**
 * SetCookieTest
 *
 * @group http-cookies
 * @group set-cookie
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Http\Cookies
 */
#[Group(
    'http-cookies',
    'set-cookies',
)]
class SetCookieTest extends UnitTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Creates a new Set-Cookie instance
     *
     * @param array $data [optional]
     *
     * @return SetCookieInterface
     *
     * @throws Throwable
     */
    protected function makeCookie(array $data = []): SetCookieInterface
    {
        return new SetCookie($data);
    }

    /**
     * Creates dummy data for a Set-Cookie instance
     *
     * @param array $data [optional] Overwrite data
     *
     * @return array
     */
    protected function cookieData(array $data = []): array
    {
        $faker = $this->getFaker();

        return array_merge([
            'name' => $faker->word(),
            'value' => $faker->sha1(),
            'expires' => $faker->unixTime(),
            'maxAge' => $faker->randomDigitNotNull(),
            'domain' => $faker->domainName(),
            'path' => '/' . $faker->word(),
            'secure' => $faker->boolean(),
            'httpOnly' => $faker->boolean(),
            'sameSite' => $faker->randomElement([
                SetCookieInterface::SAME_SITE_NONE,
                SetCookieInterface::SAME_SITE_LAX,
                SetCookieInterface::SAME_SITE_STRICT,
            ])
        ], $data);
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
        $data = $this->cookieData();

        $cookie = $this->makeCookie($data);

        $this->assertSame($data['name'], $cookie->getName(), 'Incorrect name');
        $this->assertSame($data['value'], $cookie->getValue(), 'Incorrect value');

        $expectedExpires = gmdate(DateTime::RFC7231, $data['expires']);
        $this->assertSame($expectedExpires, $cookie->getExpires(), 'Incorrect expires');

        $this->assertSame($data['maxAge'], $cookie->getMaxAge(), 'Incorrect max-age');
        $this->assertSame($data['domain'], $cookie->getDomain(), 'Incorrect domain');
        $this->assertSame($data['path'], $cookie->getPath(), 'Incorrect path');
        $this->assertSame($data['secure'], $cookie->isSecure(), 'Incorrect secure');
        $this->assertSame($data['httpOnly'], $cookie->isHttpOnly(), 'Incorrect http-only');
        $this->assertSame($data['sameSite'], $cookie->getSameSite(), 'Incorrect same-site');
    }

    /**
     * @test
     *
     * @throws Throwable
     */
    #[Test]
    public function canExportToArray()
    {
        $data = $this->cookieData();

        $cookie = $this->makeCookie($data);

        $result = $cookie->toArray();
        ConsoleDebugger::output($result);

        $expected = array_merge($data, [ 'expires' => gmdate(DateTime::RFC7231, $data['expires']) ]);
        $this->assertSame($expected, $result);
    }
}
