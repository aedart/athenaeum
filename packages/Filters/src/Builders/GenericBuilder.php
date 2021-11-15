<?php

namespace Aedart\Filters\Builders;

use Aedart\Contracts\Filters\Processor;
use Aedart\Filters\BaseBuilder;
use Illuminate\Http\Request;

/**
 * Generic Filters Builder
 *
 * @see \Aedart\Filters\BaseBuilder
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Filters\Builders
 */
class GenericBuilder extends BaseBuilder
{
    /**
     * Processors map
     *
     * @var array
     */
    protected array $processors = [];

    /**
     * {@inheritDoc}
     *
     * @param Processor[] $processors [optional]
     */
    public function __construct(Request $request, array $processors = [])
    {
        parent::__construct($request);

        $this->processors = $processors;
    }

    /**
     * @inheritDoc
     */
    public function processors(): array
    {
        return $this->processors;
    }
}
