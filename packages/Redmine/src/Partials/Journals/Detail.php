<?php

namespace Aedart\Redmine\Partials\Journals;

use Aedart\Dto\ArrayDto;

/**
 * Journal Detail Entry
 *
 * @property string $property
 * @property string $name
 * @property mixed $old_value
 * @property mixed $new_value
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine\Partials\Journals
 */
class Detail extends ArrayDto
{
    protected array $allowed = [
        'property' => 'string',
        'name' => 'string',
        'old_value' => 'string', // Type ignored - see getter / setter
        'new_value' => 'string' // Type ignored - see getter / setter
    ];

    /**
     * Set the old value
     *
     * @param mixed $value [optional]
     *
     * @return self
     */
    public function setOldValue(mixed $value = null): static
    {
        $this->properties['old_value'] = $value;

        return $this;
    }

    /**
     * Get the old value
     *
     * @return mixed
     */
    public function getOldValue(): mixed
    {
        return $this->properties['old_value'];
    }

    /**
     * Set the new value
     *
     * @param mixed $value [optional]
     *
     * @return self
     */
    public function setNewValue(mixed $value = null): static
    {
        $this->properties['new_value'] = $value;

        return $this;
    }

    /**
     * Get the new value
     *
     * @return mixed
     */
    public function getNewValue(): mixed
    {
        return $this->properties['new_value'];
    }
}
