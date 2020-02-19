<?php

namespace Aedart\Tests\TestCases;

use Aedart\Support\Helpers\Console\ArtisanTrait;
use Aedart\Testing\TestCases\AthenaeumTestCase;
use Codeception\Configuration;

/**
 * Athenaeum Application Test Case
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\TestCases
 */
abstract class AthenaeumCoreTestCase extends AthenaeumTestCase
{
    use ArtisanTrait;

    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * @inheritdoc
     */
    protected function applicationPaths(): array
    {
        return array_merge(parent::applicationPaths(), [
            'configPath' => Configuration::dataDir() . 'configs' . DIRECTORY_SEPARATOR . 'application'
        ]);
    }
}
