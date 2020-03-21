<?php

namespace Aedart\Http\Cookies;

use Aedart\Contracts\Http\Cookies\Cookie as CookieInterface;
use InvalidArgumentException;
use Throwable;

/**
 * Http Cookie
 *
 * @see \Aedart\Contracts\Http\Cookies\Cookie
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Cookies
 */
class Cookie implements CookieInterface
{
    /**
     * Cookie-name
     *
     * @var string|null
     */
    protected ?string $name = null;

    /**
     * Cookie-value
     *
     * @var string|null
     */
    protected ?string $value = null;

    /**
     * Cookie constructor.
     *
     * @param array $data [optional] Cookie's properties
     *
     * @throws Throwable
     */
    public function __construct(array $data = [])
    {
        $this->populate($data);
    }

    /**
     * @inheritDoc
     */
    public function populate(array $data = []): void
    {
        foreach ($data as $property => $value) {
            $this->populateProperty($property, $value);
        }
    }

    /**
     * @inheritDoc
     */
    public function name(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function value(?string $value = null)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'name' => $this->getName(),
            'value' => $this->getValue()
        ];
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Set a given property's value
     *
     * @param string $property
     * @param mixed $value
     *
     * @throws InvalidArgumentException If property does not exist
     */
    protected function populateProperty(string $property, $value)
    {
        if (!method_exists($this, $property)) {
            throw new InvalidArgumentException(sprintf('Property %s does not exist', $property));
        }

        $this->{$property}($value);
    }
}
