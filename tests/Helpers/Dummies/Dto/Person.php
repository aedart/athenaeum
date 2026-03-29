<?php

namespace Aedart\Tests\Helpers\Dummies\Dto;

use Aedart\Dto\Dto;
use Aedart\Tests\Helpers\Dummies\Contracts\Note as NoteInterface;

/**
 * Person
 *
 * FOR TESTING ONLY
 *
 * @property string $name
 * @property int $age
 * @property Address $address
 * @property NoteInterface $note
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Dto
 */
class Person extends Dto
{
    /**
     * Name of person
     *
     * @var string|null
     */
    protected null|string $name = null;

    /**
     * Age of person
     *
     * @var int|null
     */
    protected null|int $age = null;

    /**
     * Address
     *
     * @var Address|null
     */
    protected null|Address $address = null;

    /**
     * Note
     *
     * @var NoteInterface|null
     */
    protected null|NoteInterface $note = null;

    /**
     * Set name
     *
     * @param string|null $name Name of person
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
     * Set age
     *
     * @param int|null $age Age of person
     *
     * @return self
     */
    public function setAge(null|int $age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return int|null age or null if none age has been set
     */
    public function getAge(): null|int
    {
        return $this->age;
    }

    /**
     * Set address
     *
     * @param Address|null $address Address
     *
     * @return self
     */
    public function setAddress(null|Address $address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return Address|null address or null if none address has been set
     */
    public function getAddress(): null|Address
    {
        return $this->address;
    }

    /**
     * Set note
     *
     * @param NoteInterface|null $note Note
     *
     * @return self
     */
    public function setNote(null|NoteInterface $note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return NoteInterface|null note or null if none note has been set
     */
    public function getNote(): null|NoteInterface
    {
        return $this->note;
    }
}
