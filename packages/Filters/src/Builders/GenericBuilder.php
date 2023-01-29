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
 * @author Alin Eugen Deac <aedart@gmail.com>
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

        $this->setProcessors($processors);
    }

    /**
     * Set the processors to be applied
     *
     * @see processors
     *
     * @param array $processors [optional]
     *
     * @return self
     */
    public function setProcessors(array $processors = []): static
    {
        $this->processors = $processors;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function processors(): array
    {
        return $this->processors;
    }
}
