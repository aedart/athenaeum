<?php

namespace Aedart\Contracts;

use Aedart\Contracts\Utils\Populatable;
use ArrayAccess;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonException;
use JsonSerializable;
use Stringable;

/**
 * Data Transfer Object (DTO)
 *
 * Variation / Interpretation of the Data Transfer Object (DTO) design pattern (Distribution Pattern).
 * A DTO is responsible for;
 *
 * - Holding data (properties / attributes) for remote calls, e.g. client server communication
 * - Be serializable
 * - Contain NO additional behaviour, e.g. business logic
 *
 * @link https://martinfowler.com/eaaCatalog/dataTransferObject.html
 * @link https://en.wikipedia.org/wiki/Data_transfer_object
 * @link https://en.wikipedia.org/wiki/Mutator_method
 * @link http://php.net/manual/en/language.oop5.overloading.php
 * @link http://php.net/manual/en/class.arrayaccess.php
 * @link https://en.wikipedia.org/wiki/Inversion_of_control
 * @link https://www.php-fig.org/psr/psr-11/
 * @link http://php.net/manual/en/class.jsonserializable.php
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts
 */
interface Dto extends ArrayAccess,
    Arrayable,
    Populatable,
    Jsonable,
    JsonSerializable,
    Stringable
{
    /**
     * Returns a list of the properties / attributes that
     * this Data Transfer Object can be populated with
     *
     * @return string[]
     */
    public function populatableProperties(): array;

    /**
     * Returns the container that is responsible for
     * resolving dependency injection or eventual
     * nested object
     *
     * @return Container|null IoC Service Container or null if none defined
     */
    public function container(): Container|null;

    /**
     * Returns a new instance of this Dto
     *
     * @param array $properties [optional]
     * @param Container|null $container [optional]
     *
     * @return static
     */
    public static function makeNew(array $properties = [], Container|null $container = null): static;

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
    public static function fromJson(string $json): static;
}
