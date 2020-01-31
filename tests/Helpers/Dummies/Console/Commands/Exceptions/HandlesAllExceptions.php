<?php

namespace Aedart\Tests\Helpers\Dummies\Console\Commands\Exceptions;

use Aedart\Contracts\Console\Output\LastOutputAware;
use Aedart\Core\Exceptions\Handlers\BaseExceptionHandler;
use Aedart\Support\Helpers\Console\ArtisanTrait;
use Illuminate\Console\OutputStyle;
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

        /** @var OutputStyle $output */
        $output = $console->getLastOutput();

        //dump(__METHOD__ . get_class($output));

        $output->error($exception->getMessage());

        return true;
    }
}
