<?php

namespace Aedart\Tests\Integration\Antivirus;

use Aedart\Contracts\Antivirus\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\Antivirus\Manager;
use Aedart\Contracts\Antivirus\Scanner;
use Aedart\Tests\TestCases\Antivirus\AntivirusTestCase;

/**
 * ManagerTest
 *
 * @group antivirus
 * @group antivirus-manager
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Antivirus
 */
class ManagerTest extends AntivirusTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function canObtainInstance(): void
    {
        $manager = $this->getAntivirusManager();

        $this->assertInstanceOf(Manager::class, $manager);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ProfileNotFoundException
     */
    public function canMakeDefaultScanner(): void
    {
        $scanner = $this
            ->getAntivirusManager()
            ->profile();

        $this->assertInstanceOf(Scanner::class, $scanner);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ProfileNotFoundException
     */
    public function failsWhenProfileNotFound(): void
    {
        $this->expectException(ProfileNotFoundException::class);

        $this
            ->getAntivirusManager()
            ->profile('unknown-profile');
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ProfileNotFoundException
     */
    public function returnsSameScannerInstance(): void
    {
        $manager = $this->getAntivirusManager();

        $scannerA = $manager->profile();
        $scannerB = $manager->profile();

        $this->assertSame($scannerA, $scannerB);
    }
}
