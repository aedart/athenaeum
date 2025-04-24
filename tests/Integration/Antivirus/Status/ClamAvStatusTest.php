<?php

namespace Aedart\Tests\Integration\Antivirus\Status;

use Aedart\Antivirus\Scanners\ClamAv\ClamAvStatus;
use Aedart\Contracts\Antivirus\Exceptions\UnsupportedStatusValueException;
use Aedart\Contracts\Antivirus\Results\Status;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Antivirus\AntivirusTestCase;
use Codeception\Attribute\Group;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Xenolope\Quahog\Result as ClamAvDriverResult;

/**
 * ClamAvStatusTest
 *
 * @group antivirus
 * @group antivirus-status
 * @group antivirus-status-clamav
 * @group clamav
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Antivirus\Status
 */
#[Group(
    'antivirus',
    'antivirus-status',
    'antivirus-status-clamav',
    'clamav',
)]
class ClamAvStatusTest extends AntivirusTestCase
{
    /**
     * @test
     *
     * @return void
     *
     * @throws UnsupportedStatusValueException
     */
    #[Test]
    public function canMakeStatus(): void
    {
        $native = Mockery::mock(ClamAvDriverResult::class);

        $status = ClamAvStatus::make($native);

        $this->assertInstanceOf(Status::class, $status);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws UnsupportedStatusValueException
     */
    #[Test]
    public function canDetermineIfOk(): void
    {
        $faker = $this->getFaker();

        $expected = $this->getFaker()->boolean();
        $reason = $faker->sentence(3);

        // Mock does not work very well... so just use a real instance instead...
        $native = new ClamAvDriverResult(
            status: $expected
                ? 'OK'
                : $faker->randomElement(['FOUND', 'ERROR']),
            filename: 'myFile.txt',
            reason: $reason,
            id: $faker->randomDigitNotNull()
        );

        $status = ClamAvStatus::make($native, $reason);

        ConsoleDebugger::output((string) $status);

        $this->assertSame($expected, $status->isOk());
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws UnsupportedStatusValueException
     */
    #[Test]
    public function doesNotPassIfStatusIsUnknown(): void
    {
        $faker = $this->getFaker();

        $reason = $faker->sentence(3);

        // Mock does not work very well... so just use a real instance instead...
        $native = new ClamAvDriverResult(
            status: 'unknown',
            filename: 'myFile.txt',
            reason: $reason,
            id: $faker->randomDigitNotNull()
        );

        $status = ClamAvStatus::make($native, $reason);

        ConsoleDebugger::output((string) $status);

        $this->assertFalse($status->isOk());
    }
}
