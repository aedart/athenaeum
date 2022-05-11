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

    /**
     * @test
     *
     * @return void
     */
    public function canCreateTreeStructure()
    {
        $path = '/home/user/projects';
        $output = Str::tree($path);

        ConsoleDebugger::output($output);

        $this->assertIsArray($output);
        $this->assertCount(3, $output);

        $this->assertSame('/home', $output[0]);
        $this->assertSame('/home/user', $output[1]);
        $this->assertSame('/home/user/projects', $output[2]);
    }
}
