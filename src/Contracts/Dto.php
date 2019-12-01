<?php

namespace Aedart\Contracts;

use Aedart\Contracts\Utils\Populatable;
use ArrayAccess;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonException;
use JsonSerializable;
use Serializable;

/**
 * Data Transfer Object (DTO)
 *
 * <br />
 *
 * Variation / Interpretation of the Data Transfer Object (DTO) design pattern (Distribution Pattern).
 * A DTO is responsible for;
 *
 * <ul>
 *      <li>Holding data (properties / attributes) for remote calls, e.g. client server communication</li>
 *      <li>Be serializable</li>
 *      <li>Contain NO additional behaviour, e.g. business logic</li>
 * </ul>
 *
 * This DTO ensures that its belonging properties / attributes can be <b>overloaded</b>,
 * if those properties / attributes have corresponding <b>getters and setters</b> (accessors and mutators).
 *
 * <br />
 *
 * In this variation of the DTO, <b>serialization defaults to Json</b>.
 *
 * <br />
 *
 * Each DTO holds an instance of a Inversion of Control (<b>IoC</b>) service container, which can be
 * used for resolving nested dependencies, when populating the DTO with data. E.g. when a DTO's property is a
 * class object instance type. However, this is implementation specific.
 *
 * <br />
 *
 * When to use a DTO:
 *
 * <ul>
 *      <li>When there is a strong need to interface DTOs, e.g. what properties must be available via getters and setters</li>
 *      <li>When you need to encapsulate data that needs to be communicated between systems and or component instances</li>
 * </ul>
 *
 * There are probably many more reasons why and when you should use DTOs. However, you should know that <b>using DTOs can / will
 * increase complexity of your project!</b>
 *
 * @link https://martinfowler.com/eaaCatalog/dataTransferObject.html
 * @link https://en.wikipedia.org/wiki/Data_transfer_object
 * @link https://en.wikipedia.org/wiki/Mutator_method
 * @link http://php.net/manual/en/language.oop5.overloading.php
 * @link http://php.net/manual/en/class.arrayaccess.php
 * @link https://en.wikipedia.org/wiki/Inversion_of_control
 * @link https://www.php-fig.org/psr/psr-11/
 * @link http://php.net/manual/en/class.jsonserializable.php
 * @link https://www.php.net/manual/en/class.serializable.php
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts
 */
interface Dto extends ArrayAccess,
    Arrayable,
    Populatable,
    Jsonable,
    JsonSerializable,
    Serializable
{
    /**
     * Returns a list of the properties / attributes that
     * this Data Transfer Object can be populated with
     *
     * @return string[]
     */
    public function populatableProperties() : array;

    /**
     * Returns the container that is responsible for
     * resolving dependency injection or eventual
     * nested object
     *
     * @return Container|null IoC service Container or null if none defined
     */
    public function container() : ?Container;

    /**
     * Returns a new instance of this Dto
     *
     * @param array $properties [optional]
     * @param Container|null $container [optional]
     *
     * @return static
     */
    public static function makeNew(array $properties = [], ?Container $container = null);

    /**
     * Create a new populated instance of this Dto from a
     * json encoded string
     *
     * @param string $json
     *
     * @return static
     *
     * @throws JsonException
     */
    public static function fromJson(string $json);
}
