<?php

namespace Aedart\Tests\Unit\MimeTypes;

use Aedart\MimeTypes\Traits\MimeTypeDetectorTrait;
use Aedart\Tests\TestCases\TraitTestCase;

/**
 * MimeTypeTraitsTest
 *
 * @group mime-types
 * @group traits
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\MimeTypes
 */
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
     * @test
     * @dataProvider awareOfComponentsProvider
     *
     * @param string $awareOfTrait
     *
     * @throws \ReflectionException
     */
    public function canInvokeAwareOfMethods(string $awareOfTrait)
    {
        $this->assertTraitMethods($awareOfTrait, null, null);
    }
}
