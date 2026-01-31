<?php

namespace Aedart\Tests\Unit\Support\Properties;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\TraitTestCase;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\Test;
use ReflectionClass;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * AwareOfTraitsTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Support\Properties
 */
#[Group(
    'support',
    'properties',
    'aware-of',
    'aware-of-properties',
)]
class AwareOfTraitsTest extends TraitTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Returns all traits in "Aedart\Support\Properties" namespace
     *
     * @return array
     * @throws \ReflectionException
     */
    public function awareOfTraits(): array
    {
        $path = 'packages/Support/src/Properties';
        $namespacePrefix = 'Aedart\Support\Properties';

        $finder = new Finder();
        $iter = $finder->in($path)->name('*.php');

        $output = [];
        foreach ($iter as $fileInfo) {
            /** @var SplFileInfo $fileInfo */

            // Obtain class path
            $partial = str_replace($path, $namespacePrefix, $fileInfo->getPathname());
            $partial = str_replace('/', '\\', $partial);
            $class = str_replace('.php', '', $partial);

            $reflection = new ReflectionClass($class);

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
     * @param string $trait Class path
     *
     * @throws \ReflectionException
     */
    #[DataProvider('awareOfTraits')]
    #[Test]
    public function canInvokeMethods(string $trait)
    {
        $this->assertTraitMethods($trait);
    }
}
