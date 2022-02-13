<?php

namespace Aedart\Http\Clients\Requests\Builders\Concerns;

use Aedart\Contracts\Http\Clients\Requests\Builder;

/**
 * Concerns Http Body
 *
 * @see Builder
 * @see Builder::withData
 * @see Builder::setData
 * @see Builder::hasData
 * @see Builder::getData
 * @see Builder::withRawPayload
 * @see Builder::getRawPayload
 * @see Builder::hasRawPayload
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Concerns
 */
trait HttpBody
{
    /**
     * The request payload (body)
     *
     * Might be empty, if raw payload used.
     *
     * @var array
     */
    protected array $data = [];

    /**
     * Raw payload (body) of request.
     *
     * Might NOT be set, if data is set via
     * "withData" or "setData".
     *
     * @var mixed
     */
    protected mixed $rawPayload;

    /**
     * @inheritdoc
     */
    public function withData(array $data): static
    {
        return $this->setData(
            array_merge($this->getData(), $data)
        );
    }

    /**
     * @inheritdoc
     */
    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function hasData(): bool
    {
        return !empty($this->data);
    }

    /**
     * @inheritdoc
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @inheritdoc
     */
    public function withRawPayload(mixed $body): static
    {
        $this->rawPayload = $body;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getRawPayload(): mixed
    {
        return $this->rawPayload;
    }

    /**
     * @inheritdoc
     */
    public function hasRawPayload(): bool
    {
        return !empty($this->rawPayload);
    }
}
