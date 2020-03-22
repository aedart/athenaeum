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
    protected $rawPayload;

    /**
     * Add data to the next request's payload (body).
     *
     * Method will merge given data with existing payload.
     *
     * Depending on driver, method might not allow setting
     * data if a raw payload has been set.
     *
     * @see setData
     * @see getData
     *
     * @param array $data Decoded payload, key-value pairs
     *
     * @return self
     *
     * @throws Throwable
     */
    public function withData(array $data): Builder
    {
        return $this->setData(
            array_merge($this->getData(), $data)
        );
    }

    /**
     * Set the next request's payload (body).
     *
     * Method will overwrite existing data.
     *
     * Depending on driver, method might not allow setting
     * data if a raw payload has been set.
     *
     * @see withData
     * @see getData
     *
     * @param array $data Decoded payload, key-value pairs
     *
     * @return self
     *
     * @throws Throwable
     */
    public function setData(array $data): Builder
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Determine if next request has payload data
     *
     * @return bool
     */
    public function hasData(): bool
    {
        return !empty($this->data);
    }

    /**
     * Get the next request's payload (body)
     *
     * @return array Decoded payload, key-value pairs
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Set the next request's raw payload (body)
     *
     * Depending on driver, method might not allow setting
     * the raw payload, if data has already been set.
     *
     * If a raw payload has already been set, invoking this
     * method will result in existing payload being
     * overwritten.
     *
     * @see getRawPayload
     * @see withData
     *
     * @param mixed $body
     *
     * @return self
     *
     * @throws Throwable
     */
    public function withRawPayload($body): Builder
    {
        $this->rawPayload = $body;

        return $this;
    }

    /**
     * Get the next request's raw payload (body)
     *
     * If data has been set via {@see withData} or {@see setData},
     * then this method will not return anything (null).
     *
     * @see withData
     * @see withRawPayload
     *
     * @return mixed Null if raw payload not set
     */
    public function getRawPayload()
    {
        return $this->rawPayload;
    }

    /**
     * Determine if the next request has a raw
     * payload (body) set
     *
     * @return bool
     */
    public function hasRawPayload(): bool
    {
        return !empty($this->rawPayload);
    }
}
