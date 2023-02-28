<?php

namespace Aedart\Tests\Integration\Antivirus\Scanners;

use Aedart\Antivirus\Scanners\ClamAv\AdaptedClient;
use Aedart\Contracts\Antivirus\Exceptions\AntivirusException;
use Aedart\Contracts\Antivirus\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\Antivirus\Scanner;
use Aedart\Contracts\Utils\HasMockableDriver;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Antivirus\AntivirusTestCase;
use Mockery\MockInterface;
use Xenolope\Quahog\Result;

/**
 * ClamAvTest
 *
 * @group antivirus
 * @group antivirus-scanners
 * @group antivirus-scanners-clamav
 * @group clamav
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Antivirus\Scanners
 */
class ClamAvTest extends AntivirusTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Returns the scanner to be tested...
     *
     * @param callable|null $mockCallback [optional] Callback to configure native driver mocking.
     * @param array $options [optional]
     *
     * @return Scanner
     *
     * @throws ProfileNotFoundException
     */
    public function scanner(callable|null $mockCallback = null, array $options = []): Scanner
    {
        $mockSetup = function (Scanner|HasMockableDriver $scanner) use ($mockCallback) {
            $mock = $scanner->mockDriver(AdaptedClient::class);

            $mockCallback($mock);
        };

        return $this->makeScanner('clamav', $options, $mockSetup);
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     *
     * @return void
     *
     * @throws ProfileNotFoundException
     * @throws AntivirusException
     */
    public function canScanCleanFile(): void
    {
        $scanner = $this->scanner(function (MockInterface $mock) {
            $result = new Result(
                status: 'OK',
                filename: $this->cleanFile(),
                reason: null,
                id: null
            );

            $mock
                ->shouldReceive('scanResourceStream')
                ->withAnyArgs()
                ->andReturn($result);
        });

        $result = $scanner->scan($this->cleanFile());

        ConsoleDebugger::output($result->toArray());

        $this->assertTrue($result->isOk());
    }
}
