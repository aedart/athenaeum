<?php

namespace Aedart\Tests\Unit\Utils;

use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Helpers\PopulateHelper;
use Exception;

/**
 * PopulateHelperTest
 *
 * @group utils
 * @group populate-helper
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Utils
 */
class PopulateHelperTest extends UnitTestCase
{
    /**
     * @test
     */
    public function canVerifyRequiredProperties()
    {
        $data = [
            'a' => true,
            'b' => true,
            'c' => true,
        ];

        $required = ['a', 'b', 'c'];

        PopulateHelper::verifyRequired($data, $required);
    }

    /**
     * @test
     */
    public function failsIfIncorrectCount()
    {
        $this->expectException(Exception::class);

        $data = [
            'a' => true,
            'b' => true,
            'c' => true,
        ];

        $required = ['a', 'b', 'c', 'd'];

        PopulateHelper::verifyRequired($data, $required);
    }

    /**
     * @test
     */
    public function failsIfRequiredMissing()
    {
        $this->expectException(Exception::class);

        $data = [
            'a' => true,
            'b' => true,
            'c' => true,
        ];

        $required = ['a', 'b', 'd'];

        PopulateHelper::verifyRequired($data, $required);
    }
}
