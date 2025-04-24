<?php


namespace Aedart\Tests\Unit\Utils;

use Aedart\Contracts\Utils\Random\StringRandomizer;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Str;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * StrTest
 *
 * @group utils
 * @group utils-str
 * @group str
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Utils
 */
#[Group(
    'utils',
    'utils-str',
    'str',
)]
class StrTest extends UnitTestCase
{
    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function returnsRandomizer(): void
    {
        $randomizer = Str::randomizer();

        $this->assertInstanceOf(StringRandomizer::class, $randomizer);
    }

    /**
     * @test
     */
    #[Test]
    public function canConvertSlugIntoWords()
    {
        $slug = 'users.slug-with-multiple_separators';
        $output = (string) Str::slugToWords($slug);

        ConsoleDebugger::output($output);

        $this->assertSame('users slug with multiple separators', $output);
    }
}
