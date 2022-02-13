<?php

namespace Aedart\Dto;

use Aedart\Contracts\Dto as DtoInterface;
use Aedart\Dto\Partials\DtoPartial;
use Aedart\Dto\Partials\IoCPartial;
use Aedart\Properties\Overload;
use Aedart\Utils\Helpers\MethodHelper;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\Container;
use ReflectionClass;
use ReflectionException;
use Throwable;

/**
 * Abstract Data Transfer Object
 *
 * <br />
 *
 * This DTO abstraction offers default implementation of the following;
 *
 * <ul>
 *      <li>Overloading of properties, if they have getters and setters defined</li>
 *      <li>Array-accessibility of properties, if properties have getters and setters defined</li>
 *      <li>Population of properties via array</li>
 *      <li>Resolving nested dependencies, via a IoC service container, if one is available</li>
 *      <li>Exportation of properties to an array</li>
 *      <li>Serialization of properties to json</li>
 * </ul>
 *
 * @see \Aedart\Contracts\Dto
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Dto
 */
abstract class Dto implements DtoInterface
{
    use Overload {
        __set as __setFromOverload;
    }
    use IoCPartial;
    use DtoPartial;

    /**
     * Dto constructor.
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
     * {@inheritdoc}
     *
     * @throws ReflectionException
     * @throws BindingResolutionException
     * @throws Throwable
     */
    public function __set(string $name, mixed $value): void
    {
        $resolvedValue = $value;

        $methodName = MethodHelper::makeSetterName($name);
        if ($this->hasInternalMethod($methodName)) {
            $resolvedValue = $this->resolveValue($methodName, $value);
        }

        $this->__setFromOverload($name, $resolvedValue);
    }

    /**
     * {@inheritdoc}
     *
     * @throws ReflectionException
     */
    public function populatableProperties(): array
    {
        $reflection = new ReflectionClass($this);
        $properties = $reflection->getProperties();

        $output = [];
        foreach ($properties as $reflectionProperty) {
            $name = $reflectionProperty->getName();
            $method = MethodHelper::makeGetterName($name);

            if ($this->hasInternalMethod($method)) {
                $output[] = $name;
            }
        }
        return $output;
    }
}
