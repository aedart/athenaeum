<?php

namespace Aedart\Tests\Helpers\Dummies\Filters\Processors;

use Aedart\Contracts\Filters\BuiltFiltersMap;
use Aedart\Filters\BaseProcessor;
use Aedart\Filters\Exceptions\InvalidParameter;

/**
 * Invalid Param Fail Processor
 *
 * FOR TESTING PURPOSES ONLY.
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Helpers\Dummies\Filters\Processors
 */
class InvalidParamFailProcessor extends BaseProcessor
{
    /**
     * @inheritDoc
     */
    public function process(BuiltFiltersMap $built, callable $next)
    {
        throw InvalidParameter::make($this, sprintf('Test failure for %s parameter', $this->parameter()));
    }
}
