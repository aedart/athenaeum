<?php

namespace Aedart\Tests\Helpers\Dummies\Filters\Processors;

use Aedart\Contracts\Filters\BuiltFiltersMap;
use Aedart\Filters\BaseProcessor;
use Aedart\Testing\Helpers\ConsoleDebugger;

/**
 * Null Processor
 *
 * INTENDED FOR TESTING PURPOSES ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Filters\Processors
 */
class NullProcessor extends BaseProcessor
{
    /**
     * State whether this processor has been
     * invoked its process method or not
     *
     * @var bool
     */
    public bool $isProcessed = false;

    /**
     * @inheritDoc
     */
    public function process(BuiltFiltersMap $built, callable $next): mixed
    {
        $this->isProcessed = true;

        ConsoleDebugger::output(sprintf('Null processor for %s processed', $this->parameter()));

        return $next($built);
    }
}
