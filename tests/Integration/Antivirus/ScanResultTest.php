<?php

namespace Aedart\Tests\Integration\Antivirus;

use Aedart\Contracts\Antivirus\Results\ScanResult;
use Aedart\Contracts\Antivirus\Results\Status;
use Aedart\Support\Facades\IoCFacade;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Antivirus\AntivirusTestCase;
use Mockery;
use Psr\Container\ContainerExceptionInterface;

/**
 * ScanResultTest
 *
 * @group antivirus
 * @group antivirus-scan-result
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Antivirus
 */
class ScanResultTest extends AntivirusTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function canMakeScanResult(): void
    {
        $status = Mockery::mock(Status::class);

        $args = [
            'status' => $status,
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
        $this->assertSame($args['filename'], $result->filename(), 'incorrect filename');
        $this->assertSame($args['filesize'], $result->filesize(), 'incorrect filesize');
        $this->assertSame($args['details'], $result->details(), 'incorrect details');
        $this->assertSame($args['user'], $result->user(), 'incorrect user');
        $this->assertNotEmpty($result->datetime(), 'default datetime was expected');
    }

    /**
     * @test
     *
     * @return void
     */
    public function failsWhenStatusNotProvided(): void
    {
        $this->expectException(ContainerExceptionInterface::class);

        $args = [
            'filename' => 'my_file.txt',
            'filesize' => 3241,
            'details' => [ 1, 2, 3],
            'user' => 'James Doe'
        ];

        IoCFacade::make(ScanResult::class, $args);
    }

    /**
     * @test
     *
     * @return void
     */
    public function failsWhenInvalidStatusProvided(): void
    {
        $this->expectException(ContainerExceptionInterface::class);

        $args = [
            'status' => 'invalid',
            'filename' => 'my_file.txt',
            'filesize' => 3241,
            'details' => [ 1, 2, 3],
            'user' => 'James Doe'
        ];

        IoCFacade::make(ScanResult::class, $args);
    }

    /**
     * @test
     *
     * @return void
     */
    public function failsWhenFilenameNotProvided(): void
    {
        $this->expectException(ContainerExceptionInterface::class);

        $status = Mockery::mock(Status::class);

        $args = [
            'status' => $status,
            // 'filename' => 'my_file.txt',
            'filesize' => 3241,
            'details' => [ 1, 2, 3],
            'user' => 'James Doe'
        ];

        IoCFacade::make(ScanResult::class, $args);
    }

    /**
     * @test
     *
     * @return void
     */
    public function failsWhenFilesizeNotProvided(): void
    {
        $this->expectException(ContainerExceptionInterface::class);

        $status = Mockery::mock(Status::class);

        $args = [
            'status' => $status,
            'filename' => 'my_file.txt',
            // 'filesize' => 3241,
            'details' => [ 1, 2, 3],
            'user' => 'James Doe'
        ];

        IoCFacade::make(ScanResult::class, $args);
    }
}