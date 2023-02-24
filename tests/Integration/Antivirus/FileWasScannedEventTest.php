<?php

namespace Aedart\Tests\Integration\Antivirus;

use Aedart\Contracts\Antivirus\Events\FileWasScanned;
use Aedart\Contracts\Antivirus\Results\ScanResult;
use Aedart\Support\Facades\IoCFacade;
use Aedart\Tests\TestCases\Antivirus\AntivirusTestCase;
use Mockery;
use Psr\Container\ContainerExceptionInterface;

/**
 * FileWasScannedEventTest
 *
 * @group antivirus
 * @group antivirus-events
 * @group antivirus-file-was-scanned-event
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Antivirus
 */
class FileWasScannedEventTest extends AntivirusTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function canMakeEvent(): void
    {
        $scanResult = Mockery::mock(ScanResult::class);

        $event = IoCFacade::make(FileWasScanned::class, [ 'result' => $scanResult ]);

        $this->assertInstanceOf(FileWasScanned::class, $event);
    }

    /**
     * @test
     *
     * @return void
     */
    public function failsWhenNoResultParameterGiven(): void
    {
        $this->expectException(ContainerExceptionInterface::class);

        $event = IoCFacade::make(FileWasScanned::class);

        $this->assertInstanceOf(FileWasScanned::class, $event);
    }

    /**
     * @test
     *
     * @return void
     */
    public function failsWhenResultParameterValidScanResultInstance(): void
    {
        $this->expectException(ContainerExceptionInterface::class);

        $event = IoCFacade::make(FileWasScanned::class, [ 'result' => 'invalid' ]);

        $this->assertInstanceOf(FileWasScanned::class, $event);
    }
}
