<?php

namespace Aedart\Tests\TestCases\Console;

use Aedart\Tests\TestCases\AthenaeumCoreTestCase;
use Codeception\Configuration;

/**
 * Athenaeum Core Console Test Case
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\TestCases\Console
 */
abstract class AthenaeumCoreConsoleTestCase extends AthenaeumCoreTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * @inheritdoc
     */
    protected function applicationPaths(): array
    {
        return array_merge(parent::applicationPaths(), [
            'configPath' => Configuration::dataDir() . 'configs' . DIRECTORY_SEPARATOR . 'console',
            'storagePath' => Configuration::outputDir() . 'console'
        ]);
    }
}
