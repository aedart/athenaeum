<?php

namespace Aedart\Tests\Integration\Container;

use Aedart\Contracts\Container\IoC;
use Aedart\Testing\TestCases\IntegrationTestCase;
use Illuminate\Contracts\Container\Container;

/**
 * ContainerAliasesTest
 *
 * @group ioc
 * @group container
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Container
 */
class ContainerAliasesTest extends IntegrationTestCase
{
    /**
     * Data provider
     *
     * @return array
     */
    public function aliasProvider() : array
    {
        return [
            'container interface' => [Container::class],
            'ioc interface'       => [IoC::class]
        ];
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     * @dataProvider aliasProvider
     *
     * @param string $alias
     */
    public function canUseAliasesToResolveContainer(string $alias)
    {
        $resolved = $this->ioc->get($alias);
        $this->assertSame($this->ioc, $resolved);
    }
}
