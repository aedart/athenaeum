<?php

namespace Aedart\Tests\Integration\Antivirus;

use Aedart\Antivirus\Results\GenericStatus;
use Aedart\Contracts\Antivirus\Exceptions\UnsupportedStatusValueException;
use Aedart\Contracts\Antivirus\Results\ScanResult;
use Aedart\Contracts\Antivirus\Results\Status;
use Aedart\Support\Facades\IoCFacade;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Antivirus\AntivirusTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;
use Psr\Container\ContainerExceptionInterface;

/**
 * ScanResultTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Antivirus
 */
#[Group(
    'antivirus',
    'antivirus-scan-result',
)]
class ScanResultTest extends AntivirusTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/


    /**
     * Makes a new scan status instance
     *
     * @param bool|null $pass [optional]
     * @param string|null $reason [optional]
     *
     * @return Status
     *
     * @throws UnsupportedStatusValueException
     */
    public function makeScanStatus(bool|null $pass = null, string|null $reason = null): Status
    {
        $pass = $pass ?? $this->getFaker()->boolean();

        return new GenericStatus($pass, $reason);
    }

    /*****************************************************************
     * Actual tests
     ****************************************************************/


    /**
     * @return void
     * @throws UnsupportedStatusValueException
     */
    #[Test]
    public function canMakeScanResult(): void
    {
        $status = $this->makeScanStatus();

        $args = [
            'status' => $status,
            'filepath' => '/home/my_user/files/my_file.txt',
            'filename' => 'my_file.txt',
            'filesize' => 3241,
            'details' => [ 1, 2, 3],
            'user' => 'James Doe'
        ];

        /** @var ScanResult $result */
        $result = IoCFacade::make(ScanResult::class, $args);

        // ----------------------------------------------------------------- //

        $this->assertInstanceOf(ScanResult::class, $result);

        ConsoleDebugger::output($result->toArray());

        $this->assertSame($args['status'], $result->status(), 'incorrect status');
        $this->assertSame($args['filepath'], $result->filepath(), 'incorrect filename');
        $this->assertSame($args['filename'], $result->filename(), 'incorrect filename');
        $this->assertSame($args['filesize'], $result->filesize(), 'incorrect filesize');
        $this->assertSame($args['details'], $result->details(), 'incorrect details');
        $this->assertSame($args['user'], $result->user(), 'incorrect user');
        $this->assertNotEmpty($result->datetime(), 'default datetime was expected');
    }

    /**
     * @return void
     */
    #[Test]
    public function failsWhenStatusNotProvided(): void
    {
        $this->expectException(ContainerExceptionInterface::class);

        $args = [
            'filepath' => '/home/my_user/files/my_file.txt',
            'filename' => 'my_file.txt',
            'filesize' => 3241,
            'details' => [ 1, 2, 3],
            'user' => 'James Doe'
        ];

        IoCFacade::make(ScanResult::class, $args);
    }

    /**
     * @return void
     */
    #[Test]
    public function failsWhenInvalidStatusProvided(): void
    {
        $this->expectException(ContainerExceptionInterface::class);

        $args = [
            'status' => 'invalid',
            'filepath' => '/home/my_user/files/my_file.txt',
            'filename' => 'my_file.txt',
            'filesize' => 3241,
            'details' => [ 1, 2, 3],
            'user' => 'James Doe'
        ];

        IoCFacade::make(ScanResult::class, $args);
    }

    /**
     * @return void
     * @throws UnsupportedStatusValueException
     */
    #[Test]
    public function failsWhenFilepathNotProvided(): void
    {
        $this->expectException(ContainerExceptionInterface::class);

        $status = $this->makeScanStatus();

        $args = [
            'status' => $status,
            // 'filepath' => '/home/my_user/files/my_file.txt',
            'filename' => 'my_file.txt',
            'filesize' => 3241,
            'details' => [ 1, 2, 3],
            'user' => 'James Doe'
        ];

        IoCFacade::make(ScanResult::class, $args);
    }

    /**
     * @return void
     * @throws UnsupportedStatusValueException
     */
    #[Test]
    public function failsWhenFilesizeNotProvided(): void
    {
        $this->expectException(ContainerExceptionInterface::class);

        $status = $this->makeScanStatus();

        $args = [
            'status' => $status,
            'filepath' => '/home/my_user/files/my_file.txt',
            'filename' => 'my_file.txt',
            // 'filesize' => 3241,
            'details' => [ 1, 2, 3],
            'user' => 'James Doe'
        ];

        IoCFacade::make(ScanResult::class, $args);
    }
}
