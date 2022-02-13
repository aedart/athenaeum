<?php

namespace Aedart\Tests\Helpers\Dummies\Dto;

use Aedart\Dto\Dto;

/**
 * Record
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @property string|int|float|bool|null $id Record id
 * @property array|null $data Record data...
 * @property string|Person|Organisation|null $reference Reference to something...
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Dto
 */
class Record extends Dto
{
    /**
     * Record id
     *
     * NOTE: The "strange" types are on purpose for testing purposes!
     *
     * @var string|int|float|bool|null
     */
    protected string|int|float|bool|null $id = null;

    /**
     * Data
     *
     * @var string|array|null
     */
    protected string|array|null $data = null;

    /**
     * Reference to something...
     *
     * @var string|Person|Organisation|null
     */
    protected string|Person|Organisation|null $reference = null;

    /**
     * Set the id
     *
     * @param  string|int|float|bool|null  $id
     *
     * @return self
     */
    public function setId(string|int|float|bool|null $id): static
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the id
     *
     * @return string|int|float|bool|null
     */
    public function getId(): string|int|float|bool|null
    {
        return $this->id;
    }

    /**
     * Set data
     *
     * @param  string|array|null  $data
     *
     * @return self
     */
    public function setData(string|array|null $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return string|array|null
     */
    public function getData(): string|array|null
    {
        return $this->data;
    }

    /**
     * Set reference
     *
     * @param  string|Person|Organisation|null  $reference
     *
     * @return self
     */
    public function setReference(string|Person|Organisation|null $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string|Person|Organisation|null
     */
    public function getReference(): string|Person|Organisation|null
    {
        return $this->reference;
    }
}
