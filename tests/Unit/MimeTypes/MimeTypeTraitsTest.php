<?php

namespace Aedart\Tests\Unit\MimeTypes;

use Aedart\MimeTypes\Traits\MimeTypeDetectorTrait;
use Aedart\Tests\TestCases\TraitTestCase;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * MimeTypeTraitsTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\MimeTypes
 */
#[Group(
    'mime-types',
    'traits'
)]
class MimeTypeTraitsTest extends TraitTestCase
{
    /**
     * @return array
     */
    public function awareOfComponentsProvider()
    {
        return [
            'MimeTypeDetectorTrait' => [ MimeTypeDetectorTrait::class ],
        ];
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
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
