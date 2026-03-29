<?php

namespace Aedart\Tests\Helpers\Dummies\Dto;

use Aedart\Dto\Dto;

/**
 * City
 *
 * FOR TESTING ONLY
 *
 * @property string $name
 * @property int $zipCode
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Dto
 */
class City extends Dto
{
    /**
     * Name of city
     *
     * @var string|null
     */
    protected null|string $name = null;

    /**
     * Zip Code
     *
     * @var int|null
     */
    protected null|int $zipCode = null;

    /**
     * Set name
     *
     * @param string|null $name Name of city
     *
     * @return self
     */
    public function setName(null|string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string|null name or null if none name has been set
     */
    public function getName(): null|string
    {
        return $this->name;
    }

    /**
     * Set zip code
     *
     * @param int|null $code Zip Code
     *
     * @return self
     */
    public function setZipCode(null|int $code)
    {
        $this->zipCode = $code;

        return $this;
    }

    /**
     * Get zip code
     *
     * @return int|null zip code or null if none zip code has been set
     */
    public function getZipCode(): null|int
    {
        return $this->zipCode;
    }
}
