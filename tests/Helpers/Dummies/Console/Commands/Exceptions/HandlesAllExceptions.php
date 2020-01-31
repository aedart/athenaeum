<?php

namespace Aedart\Tests\Helpers\Dummies\Console\Commands\Exceptions;

use Aedart\Contracts\Console\Output\LastOutputAware;
use Aedart\Core\Exceptions\Handlers\BaseExceptionHandler;
use Aedart\Support\Helpers\Console\ArtisanTrait;
use Throwable;

/**
 * Handles All Exceptions
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Console\Commands\Exceptions
 */
class HandlesAllExceptions extends BaseExceptionHandler
{
    use ArtisanTrait;

    /**
     * @inheritDoc
     */
    public function handle(Throwable $exception): bool
    {
        /** @var LastOutputAware $console */
        $console = $this->getArtisan();

        $output = $console->getLastOutput();

        $msg = $exception->getMessage();
        $output->write("<error>{$msg}</error>");

        return true;
    }
}
