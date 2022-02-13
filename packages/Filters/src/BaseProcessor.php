<?php

namespace Aedart\Filters;

use Aedart\Contracts\Filters\Processor;
use Aedart\Support\Helpers\Validation\ValidatorFactoryTrait;
use Illuminate\Http\Request;
use RuntimeException;

/**
 * Base Http Query Parameters Processor
 *
 * Base abstraction for processors.
 *
 * @see \Aedart\Contracts\Filters\Processor
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Filters
 */
abstract class BaseProcessor implements Processor
{
    use ValidatorFactoryTrait;

    /**
     * Evt. factory options
     *
     * @var array
     */
    protected array $options;

    /**
     * The request in question
     *
     * @var Request
     */
    protected Request $request;

    /**
     * Http query parameter to process
     *
     * @var string
     */
    protected string $parameter;

    /**
     * State whether this processor should be
     * forced applied, even when no matching
     * parameter was requested
     *
     * @var bool
     */
    protected bool $force = false;

    /**
     * BaseProcessor
     *
     * @param array $options [optional]
     */
    public function __construct(array $options = [])
    {
        $this->options = $this->makeOptions($options);
    }

    /**
     * @inheritDoc
     */
    public static function make(array $options = []): static
    {
        return new static($options);
    }

    /**
     * @inheritDoc
     */
    public function fromRequest($request): static
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function request()
    {
        if (!isset($this->request)) {
            throw new RuntimeException('Request object not specified');
        }

        return $this->request;
    }

    /**
     * @inheritDoc
     */
    public function usingParameter(string $parameter): static
    {
        $this->parameter = $parameter;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function parameter(): string
    {
        if (!isset($this->parameter)) {
            throw new RuntimeException('Parameter name not specified');
        }

        return $this->parameter;
    }

    /**
     * @inheritDoc
     */
    public function value(): array|string|int|float|null
    {
        $request = $this->request();
        $param = $this->parameter();

        if ($request->query->has($param)) {
            return $request->query->all()[$param];
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function force(bool $force = true): static
    {
        $this->force = $force;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function mustBeApplied(): bool
    {
        return $this->force;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Creates an options repository
     *
     * @param array $options [optional]
     *
     * @return array
     */
    protected function makeOptions(array $options = []): array
    {
        // The "base" processor does not require any options / settings.
        // But, if your specific processor require it, then feel free
        // to overwrite this method and set defaults.

        return $options;
    }
}
