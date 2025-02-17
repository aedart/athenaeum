<?php


namespace Aedart\Tests\Unit\Utils;

use Aedart\Contracts\Utils\Random\ArrayRandomizer;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Arr;
use Random\Engine\Mt19937;
use Throwable;

/**
 * ArrTest
 *
 * @group utils
 * @group array
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Utils
 */
class ArrTest extends UnitTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function returnsRandomizer(): void
    {
        $randomizer = Arr::randomizer();

        $this->assertInstanceOf(ArrayRandomizer::class, $randomizer);
    }

    /**
     * @test
     *
     * @throws Throwable
     */
    public function returnsSameValueWhenSeededWithStaticValue()
    {
        $list = [ 'a', 'b', 'c' ];

        $seed = 123456;

        $randomizer = Arr::randomizer(new Mt19937($seed));

        $resultA = $randomizer->value($list);
        $resultB = $randomizer->value($list);
        $resultC = $randomizer->value($list);

        ConsoleDebugger::output($resultA, $resultB, $resultC);

        $this->assertSame($resultA, $resultB);
        $this->assertSame($resultA, $resultC);
        $this->assertSame($resultB, $resultC);
    }

    /**
     * @test
     */
    public function canReturnDifferenceOfAssociate()
    {
        $original = [
            'key' => 'person',
            'value' => 'John Snow',
            'settings' => [
                'validation' => [
                    'required' => true,
                    'nullable' => true,
                    'min' => 2,
                    'max' => 50,
                ]
            ]
        ];

        $changed = [
            'key' => 'person',
            'value' => 'Smith Snow', // Changed
            'settings' => [
                'validation' => [
                    'required' => false, // Changed
                    'nullable' => true,
                    'min' => 2,
                    'max' => 100, // Changed
                ]
            ]
        ];

        $result = Arr::differenceAssoc($original, $changed);
        ConsoleDebugger::output($result);

        $this->assertArrayHasKey('value', $result);
        $this->assertArrayHasKey('settings', $result);

        $settings = $result['settings'];
        $this->assertArrayHasKey('validation', $settings);

        $validation = $settings['validation'];
        $this->assertArrayHasKey('required', $validation);
        $this->assertArrayHasKey('max', $validation);
    }

    /**
     * @test
     */
    public function doesNotFailDiffOfAssocWhenEmptyNestedArrays()
    {
        $original = [
            'key' => 'person',
            'value' => 'John Snow',
            'settings' => []
        ];

        $changed = [
            'key' => 'person',
            'value' => 'Jack Snow', // Changed
            'settings' => [] // Can cause array to string conversion!, using php's array_diff_assoc
        ];

        $result = Arr::differenceAssoc($changed, $original);
        ConsoleDebugger::output($result);

        $this->assertArrayHasKey('value', $result);
    }

    /**
     * @test
     */
    public function doesNotFailDiffOfAssocWhenEmptyNullValues()
    {
        $original = [
            'key' => null,
        ];

        $changed = [
            'key' => null,
        ];

        $result = Arr::differenceAssoc($changed, $original);
        ConsoleDebugger::output($result);

        $this->assertEmpty($result);
    }

    /**
     * @test
     *
     * @return void
     */
    public function canCreateTreeStructure()
    {
        $path = '/home/user/projects';
        $output = Arr::tree($path);

        ConsoleDebugger::output($output);

        $this->assertIsArray($output);
        $this->assertCount(3, $output);

        $this->assertSame('/home', $output[0]);
        $this->assertSame('/home/user', $output[1]);
        $this->assertSame('/home/user/projects', $output[2]);
    }
}
