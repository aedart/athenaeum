<?php

namespace Aedart\Tests\Unit\Support\Properties;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\TraitTestCase;
use hanneskod\classtools\Iterator\ClassIterator;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;

/**
 * AwareOfTraitsTest
 *
 * @group support
 * @group properties
 * @group aware-of
 * @group aware-of-properties
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Support\Properties
 */
class AwareOfTraitsTest extends TraitTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Returns all traits in "Aedart\Support\Properties" namespace
     *
     * @return array
     */
    public function awareOfTraits() : array
    {
        $finder = new Finder;
        $iter = new ClassIterator($finder->in('packages/Support/src/Properties'));

        $output = [];
        foreach ($iter as $reflection){
            /** @var \ReflectionClass $reflection */

            $namespace = $reflection->getName();
            $parts = explode('\\', $reflection->getName());

            $componentName = Str::replaceLast('Trait', '', array_pop($parts));
            $type = Str::singular(strtolower(array_pop($parts)));

            //ConsoleDebugger::output($componentName, $type);

            $output[$componentName . ' (' . $type . ')'] = [ $namespace ];
        }

        ksort($output);

        //ConsoleDebugger::output($output);

        return $output;
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     * @dataProvider awareOfTraits
     *
     * @param string $trait Class path
     *
     * @throws \ReflectionException
     */
    public function canInvokeMethods(string $trait)
    {
        $this->assertTraitMethods($trait);
    }
}
