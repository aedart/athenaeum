<?php

namespace Aedart\Tests\Unit\Http\Cookies;

use Aedart\Contracts\Http\Cookies\SameSite;
use Aedart\Testing\TestCases\UnitTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;
use ValueError;

#[Group(
    'http-cookies',
    'set-cookies',
    'same-site',
    'same-site-enum',
)]
class SameSiteEnumTest extends UnitTestCase
{
    #[Test]
    public function canMakeFromValue(): void
    {
        $values = SameSite::values();
        $value = $this->getFaker()->randomElement(
            array_map(fn (string $value) => strtoupper($value), $values)
        );

        // If no failure, then test passes...
        SameSite::fromValue($value);
    }

    #[Test]
    public function failsWhenValueIsUnknown(): void
    {
        $this->expectException(ValueError::class);

        SameSite::fromValue('unknown-policy');
    }

    #[Test]
    public function canTryMakeFromValue(): void
    {
        $values = SameSite::values();
        $value = $this->getFaker()->randomElement(
            array_map(fn (string $value) => strtoupper($value), $values)
        );

        // If no failure, then test passes...
        $policy = SameSite::tryFromValue($value);

        $this->assertInstanceOf(SameSite::class, $policy);
    }

    #[Test]
    public function returnsNullWhenValueIsUnknown(): void
    {
        $policy = SameSite::tryFromValue('unknown-policy');

        $this->assertNull($policy);
    }
}