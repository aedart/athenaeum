<?php

namespace Aedart\Tests\Helpers\Dummies\Filters\Processors;

use Aedart\Contracts\Filters\BuiltFiltersMap;
use Aedart\Filters\BaseProcessor;

/**
 * Null Processor
 *
 * INTENDED FOR TESTING PURPOSES ONLY
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
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
    public function process(BuiltFiltersMap $built, callable $next)
    {
        $this->isProcessed = true;

        return $next($built);
    }
}
