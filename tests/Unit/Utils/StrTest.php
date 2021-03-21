<?php


namespace Aedart\Tests\Unit\Utils;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Str;

/**
 * StrTest
 *
 * @group utils
 * @group utils-str
 * @group str
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Unit\Utils
 */
class StrTest extends UnitTestCase
{
    /**
     * @test
     */
    public function canConvertSlugIntoWords()
    {
        $slug = 'users.slug-with-multiple_separators';
        $output = (string) Str::slugToWords($slug);

        ConsoleDebugger::output($output);

        $this->assertSame('users slug with multiple separators', $output);
    }
}
