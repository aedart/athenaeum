<?php

namespace Aedart\Tests\Helpers\Dummies\Dto;

use Aedart\Dto\Dto;

/**
 * Address
 *
 * FOR TESTING ONLY
 *
 * @property string $street
 * @property City $city
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Dto
 */
class Address extends Dto
{
    /**
     * Name of street
     *
     * @var string|null
     */
    protected null|string $street = null;

    /**
     * City
     *
     * @var City|null
     */
    protected null|City $city = null;

    /**
     * Set street
     *
     * @param string|null $name Name of street
     *
     * @return self
     */
    public function setStreet(null|string $name)
    {
        $this->street = $name;

        return $this;
    }

    /**
     * Get street
     *
     * @return string|null street or null if none street has been set
     */
    public function getStreet(): null|string
    {
        return $this->street;
    }

    /**
     * Set city
     *
     * @param City|null $city City
     *
     * @return self
     */
    public function setCity(null|City $city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return City|null city or null if none city has been set
     */
    public function getCity(): null|City
    {
        return $this->city;
    }
}
