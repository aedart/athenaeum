<?php

namespace Aedart\Tests\Integration\Antivirus\Scanners;

use Aedart\Antivirus\Scanners\ClamAv\AdaptedClient;
use Aedart\Contracts\Antivirus\Exceptions\AntivirusException;
use Aedart\Contracts\Antivirus\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\Antivirus\Scanner;
use Aedart\Contracts\Utils\HasMockableDriver;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Antivirus\AntivirusTestCase;
use Codeception\Attribute\Group;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;
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
#[Group(
    'antivirus',
    'antivirus-scanners',
    'antivirus-scanners-clamav',
    'clamav',
)]
class ClamAvTest extends AntivirusTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Returns the scanner to be tested...
     *
     * @param callable|null $callback [optional] Callback to configure native driver mock.
     * @param array $options [optional]
     *
     * @return Scanner
     *
     * @throws ProfileNotFoundException
     */
    public function scanner(callable|null $callback = null, array $options = []): Scanner
    {
        $mockSetup = function (Scanner|HasMockableDriver $scanner) use ($callback) {
            $mock = $scanner->mockDriver(AdaptedClient::class);

            $callback($mock);
        };

        return $this->makeScanner('clamav', $options, $mockSetup);
    }

    /**
     * Returns a mocked driver scan results
     *
     * @param MockInterface $mock
     * @param string $status
     * @param string $file
     * @param string|null $reason
     * @param string|null $id
     *
     * @return MockInterface
     */
    public function mockDriverScanResult(
        MockInterface $mock,
        string $status,
        string $file,
        string|null $reason = null,
        string|null $id = null
    ): MockInterface {
        $result = new Result(
            status: strtoupper($status),
            filename: $file,
            reason: $reason,
            id: $id
        );

        $mock
            ->shouldReceive('hasSession')
            ->andReturn(true);

        $mock
            ->shouldReceive('scanResourceStream')
            ->withAnyArgs()
            ->andReturn($result);

        return $mock;
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
    #[Test]
    public function canScanCleanFile(): void
    {
        $file = $this->cleanFile();
        $scanner = $this->scanner(function (MockInterface $mock) use ($file) {
            $this->mockDriverScanResult(
                mock: $mock,
                status: 'ok',
                file: $file
            );
        });

        $result = $scanner->scan($file);
        ConsoleDebugger::output($result->toArray());

        $this->assertTrue($result->isOk());
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ProfileNotFoundException
     * @throws AntivirusException
     */
    #[Test]
    public function canScanInfectedFile(): void
    {
        $file = $this->infectedFile();
        $scanner = $this->scanner(function (MockInterface $mock) use ($file) {
            $this->mockDriverScanResult(
                mock: $mock,
                status: 'found',
                file: $file
            );
        });

        $result = $scanner->scan($file);
        ConsoleDebugger::output($result->toArray());

        $this->assertTrue($result->hasFailed());
        $this->assertTrue($result->status()->hasInfection(), 'Status SHOULD indicate that infection was found');
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ProfileNotFoundException
     * @throws AntivirusException
     */
    #[Test]
    public function canScanCompressedInfectedFile(): void
    {
        $file = $this->compressedInfectedFile();
        $scanner = $this->scanner(function (MockInterface $mock) use ($file) {
            $this->mockDriverScanResult(
                mock: $mock,
                status: 'found',
                file: $file
            );
        });

        $result = $scanner->scan($file);
        ConsoleDebugger::output($result->toArray());

        $this->assertTrue($result->hasFailed());
        $this->assertTrue($result->status()->hasInfection(), 'Status SHOULD indicate that infection was found');
    }
}
