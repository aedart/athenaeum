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
    protected string|null $name = null;

    /**
     * Cookie-value
     *
     * @var string|null
     */
    protected string|null $value = null;

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
    public function populate(array $data = []): static
    {
        foreach ($data as $property => $value) {
            $this->populateProperty($property, $value);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function name(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string|null
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function value(string|null $value = null): static
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getValue(): string|null
    {
        return $this->value;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
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
    protected function populateProperty(string $property, mixed $value)
    {
        if (!method_exists($this, $property)) {
            throw new InvalidArgumentException(sprintf('Property %s does not exist', $property));
        }

        $this->{$property}($value);
    }
}
