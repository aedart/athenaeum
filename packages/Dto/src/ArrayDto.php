<?php

namespace Aedart\Dto;

use Aedart\Contracts\Dto;
use Aedart\Dto\Partials\CastingPartial;
use Aedart\Dto\Partials\DtoPartial;
use Aedart\Dto\Partials\IoCPartial;
use Aedart\Properties\Exceptions\UndefinedProperty;
use Aedart\Utils\Helpers\MethodHelper;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\Container;
use ReflectionException;
use Throwable;

/**
 * Abstract Data Transfer Object (Array version)
 *
 * @see \Aedart\Contracts\Dto
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Dto
 */
abstract class ArrayDto implements Dto
{
    use IoCPartial;
    use DtoPartial;
    use CastingPartial;

    /**
     * The properties of this Dto
     *
     * @var array Key = property's name, value = property's value
     */
    protected array $properties = [];

    /**
     * Defines the allowed properties and their
     * data type.
     *
     * <pre>
     * [
     *      'name'      => 'string',
     *      'age'       => 'int',
     *      'address'   => \Acme\Dto\Address::class
     * ]
     * </pre>
     *
     * @var array
     */
    protected array $allowed = [];

    /**
     * ArrayDto constructor.
     *
     * @param array $properties [optional]
     * @param Container|null $container [optional]
     *
     * @throws Throwable
     */
    public function __construct(array $properties = [], Container|null $container = null)
    {
        $this
            ->setContainer($container)
            ->populate($properties);
    }

    /**
     * Returns a list of the properties / attributes that
     * this Data Transfer Object can be populated with
     *
     * @return string[]
     */
    public function populatableProperties(): array
    {
        return array_keys($this->allowed);
    }

    /*****************************************************************
     * Magic Methods
     ****************************************************************/

    /**
     * Set property
     *
     * @param string $name
     * @param mixed $value
     *
     * @return void
     *
     * @throws UndefinedProperty
     * @throws BindingResolutionException
     * @throws ReflectionException
     * @throws Throwable
     */
    public function __set(string $name, mixed $value): void
    {
        // Abort if not allowed.
        if (!array_key_exists($name, $this->allowed)) {
            throw new UndefinedProperty(sprintf('Property "%s" is not supported (not allowed)', $name));
        }

        // Invoke mutator, if one exists.
        $mutator = MethodHelper::makeSetterName($name);
        if (method_exists($this, $mutator)) {
            $this->$mutator($this->resolveValue($mutator, $value));
            return;
        }

        // Otherwise, cast value and set it.
        $this->properties[$name] = $this->castPropertyValue($name, $value);
    }

    /**
     * Get property
     *
     * @param string $name
     *
     * @return mixed
     *
     * @throws UndefinedProperty
     */
    public function __get(string $name): mixed
    {
        // Abort if not allowed.
        if (!array_key_exists($name, $this->allowed)) {
            throw new UndefinedProperty(sprintf('Property "%s" is not supported (not allowed)', $name));
        }

        // Invoke accessor, if one exists.
        $accessor = MethodHelper::makeGetterName($name);
        if (method_exists($this, $accessor)) {
            return $this->$accessor();
        }

        // Otherwise, return property if a value exists or
        // simply return null.
        if (isset($this->properties[$name])) {
            return $this->properties[$name];
        }

        return null;
    }

    /**
     * Determine if property has been set
     *
     * @param string $name
     *
     * @return bool
     */
    public function __isset(string $name): bool
    {
        return isset($this->properties[$name]);
    }

    /**
     * Unset property
     *
     * @param string $name
     */
    public function __unset(string $name): void
    {
        unset($this->properties[$name]);
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * @inheritdoc
     */
    protected function isPropertyUnset(string $property): bool
    {
        return !isset($this->{$property});
    }
}
