<?php

namespace Aedart\Tests\Integration\Antivirus;

use Aedart\Antivirus\Facades\Antivirus;
use Aedart\Antivirus\Scanners\NullScanner;
use Aedart\Contracts\Antivirus\Results\ScanResult;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Antivirus\AntivirusTestCase;
use Codeception\Attribute\Group;
use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\Attributes\Test;

/**
 * AntivirusFacadeTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Antivirus
 */
#[Group(
    'antivirus',
    'antivirus-facade',
    'facades'
)]
class AntivirusFacadeTest extends AntivirusTestCase
{
    /**
     * @return void
     */
    #[Test]
    public function canScan(): void
    {
        // Configure antivirus profile, depending on if this is a live test or not...
        if (!$this->isLive()) {
            ConsoleDebugger::output('Antivirus default profile set to null');
            Config::set('antivirus.default_scanner', 'null');
        }

        // -------------------------------------------------------------------------- //

        $file = $this->cleanFile();

        $result = Antivirus::scan($file);

        ConsoleDebugger::output($result?->toArray());

        $this->assertInstanceOf(ScanResult::class, $result);
    }

    /**
     * @return void
     */
    #[Test]
    public function canObtainScannerProfile(): void
    {
        $scanner = Antivirus::profile('null');

        $this->assertInstanceOf(NullScanner::class, $scanner);
    }
}
