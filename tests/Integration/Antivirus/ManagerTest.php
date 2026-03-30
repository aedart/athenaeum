<?php

namespace Aedart\Tests\Integration\Antivirus;

use Aedart\Contracts\Antivirus\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\Antivirus\Manager;
use Aedart\Contracts\Antivirus\Scanner;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Antivirus\AntivirusTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * ManagerTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Antivirus
 */
#[Group(
    'antivirus',
    'antivirus-manager',
)]
class ManagerTest extends AntivirusTestCase
{
    /**
     * @return void
     */
    #[Test]
    public function canObtainInstance(): void
    {
        $manager = $this->getAntivirusManager();

        $this->assertInstanceOf(Manager::class, $manager);
    }

    /**
     * @return void
     *
     * @throws ProfileNotFoundException
     */
    #[Test]
    public function canMakeDefaultScanner(): void
    {
        $scanner = $this
            ->getAntivirusManager()
            ->profile();

        $this->assertInstanceOf(Scanner::class, $scanner);
    }

    /**
     * @return void
     *
     * @throws ProfileNotFoundException
     */
    #[Test]
    public function failsWhenProfileNotFound(): void
    {
        $this->expectException(ProfileNotFoundException::class);

        $this
            ->getAntivirusManager()
            ->profile('unknown-profile');
    }

    /**
     * @return void
     *
     * @throws ProfileNotFoundException
     */
    #[Test]
    public function returnsSameScannerInstance(): void
    {
        $manager = $this->getAntivirusManager();

        $scannerA = $manager->profile();
        $scannerB = $manager->profile();

        $this->assertSame($scannerA, $scannerB);
    }

    /**
     * @return void
     */
    #[Test]
    public function forwardsDynamicCallsToDefaultScanner(): void
    {
        $manager = $this->getAntivirusManager();

        // If method call does not fail, then test is ok
        $options = $manager->getOptions();

        ConsoleDebugger::output($options);

        $this->assertIsArray($options);
    }
}
