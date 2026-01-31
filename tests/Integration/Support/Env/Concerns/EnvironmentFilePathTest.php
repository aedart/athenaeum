<?php

namespace Aedart\Tests\Integration\Support\Env\Concerns;

use Aedart\Support\Env\Concerns\EnvironmentFilePath;
use Aedart\Testing\GetterSetterTraitTester;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\Helpers\TraitTester;
use Aedart\Testing\TestCases\LaravelTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;
use ReflectionException;

/**
 * EnvironmentFilePathTest
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Integration\Support\Env\Concerns
 */
#[Group(
    'laravel',
    'support',
    'support-env',
    'support-env-concern',
)]
class EnvironmentFilePathTest extends LaravelTestCase
{
    use GetterSetterTraitTester;

    /**
     * @return void
     *
     * @throws ReflectionException
     */
    #[Test]
    public function canSetAndRetrieveEnvironmentFilePath(): void
    {
        $this->assertTraitMethods(
            trait: EnvironmentFilePath::class,
            assertDefaultIsNull: false
        );
    }

    /**
     * @return void
     *
     * @throws ReflectionException
     */
    #[Test]
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
