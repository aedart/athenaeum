<?php

namespace Aedart\Tests\TestCases;

use Aedart\Testing\TestCases\ApplicationTestCase;
use Codeception\Configuration;

/**
 * Athenaeum Application Test Case
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\TestCases
 */
abstract class AthenaeumAppTestCase extends ApplicationTestCase
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
            'configPath'    => Configuration::dataDir() . 'configs' . DIRECTORY_SEPARATOR . 'application'
        ]);
    }
}
