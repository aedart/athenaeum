<?php

namespace Aedart\Tests\Unit\Redmine\Traits;

use Aedart\Redmine\Traits\ConnectionTrait;
use Aedart\Tests\TestCases\TraitTestCase;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * RedmineTraitsTest
 *
 * @group redmine
 * @group traits
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Redmine\Traits
 */
#[Group(
    'redmine',
    'traits'
)]
class RedmineTraitsTest extends TraitTestCase
{
    /**
     * @return array
     */
    public function awareOfComponentsProvider()
    {
        return [
            'ConnectionTrait' => [ ConnectionTrait::class ],
        ];
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     * @dataProvider awareOfComponentsProvider
     *
     * @param string $awareOfTrait
     *
     * @throws \ReflectionException
     */
    #[DataProvider('awareOfComponentsProvider')]
    #[Test]
    public function canInvokeAwareOfMethods(string $awareOfTrait)
    {
        $this->assertTraitMethods($awareOfTrait, null, null);
    }
}
