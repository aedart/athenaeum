<?php

namespace Aedart\Tests\Integration\Support\Env\Concerns;

use Aedart\Support\Env\Concerns\EnvironmentFilePath;
use Aedart\Testing\GetterSetterTraitTester;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\Helpers\TraitTester;
use Aedart\Testing\TestCases\LaravelTestCase;
use ReflectionException;

/**
 * EnvironmentFilePathTest
 *
 * @group laravel
 * @group support
 * @group support-env
 * @group support-env-concerns
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Integration\Support\Env\Concerns
 */
class EnvironmentFilePathTest extends LaravelTestCase
{
    use GetterSetterTraitTester;

    /**
     * @test
     *
     * @return void
     *
     * @throws ReflectionException
     */
    public function canSetAndRetrieveEnvironmentFilePath(): void
    {
        $this->assertTraitMethods(
            trait: EnvironmentFilePath::class,
            assertDefaultIsNull: false
        );
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ReflectionException
     */
    public function hasDefaultPath(): void
    {
        // Assert a default method
        $tester = new TraitTester($this, EnvironmentFilePath::class, null);
        $getMethod = $tester->getPropertyMethodName();
        $mock = $tester->getTraitMock();

        $value = $mock->$getMethod();

        ConsoleDebugger::output($value);

        $this->assertNotNull($value, 'Default path not set');
    }
}
