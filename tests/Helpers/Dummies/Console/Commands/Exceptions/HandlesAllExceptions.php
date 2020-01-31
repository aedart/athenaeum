<?php

namespace Aedart\Tests\Helpers\Dummies\Console\Commands\Exceptions;

use Aedart\Console\Traits\CoreApplicationTrait;
use Aedart\Core\Exceptions\Handlers\BaseExceptionHandler;
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
    use CoreApplicationTrait;

    /**
     * @inheritDoc
     */
    public function handle(Throwable $exception): bool
    {
        /** @var OutputStyle $output */
        $output = $this->getCoreApplication()->make(OutputStyle::class);

        //dump($output);

        $output->error($exception->getMessage());

        return true;
    }
}
