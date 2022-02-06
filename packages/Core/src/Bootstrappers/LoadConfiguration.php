<?php

namespace Aedart\Core\Bootstrappers;

use Aedart\Config\Traits\ConfigLoaderTrait;
use Aedart\Contracts\Config\Loaders\Exceptions\InvalidPathException;
use Aedart\Contracts\Config\Parsers\Exceptions\FileParserException;
use Aedart\Contracts\Core\Application;
use Aedart\Contracts\Core\Helpers\CanBeBootstrapped;

/**
 * Load Configuration
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Core\Bootstrappers
 */
class LoadConfiguration implements CanBeBootstrapped
{
    use ConfigLoaderTrait;

    /**
     * @inheritDoc
     *
     * @throws InvalidPathException
     * @throws FileParserException
     */
    public function bootstrap(Application $application): void
    {
        $loader = $this->getConfigLoader();

        $loader
            ->setDirectory($application->configPath())
            ->load();
    }
}
