<?php

namespace Aedart\Redmine\Partials;

use Aedart\Dto\ArrayDto;

/**
 * Custom Field Reference
 *
 * @property int $id
 * @property string $name
 * @property bool|null $multiple
 * @property mixed $value
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Redmine\Partials
 */
class CustomFieldReference extends ArrayDto
{
    protected array $allowed = [
        'id' => 'int',
        'name' => 'string',
        'multiple' => 'bool',
        'value' => 'string' // type ignore - see getter / setter
    ];

    /**
     * Set the custom field value
     *
     * @param mixed $value
     *
     * @return self
     */
    public function setValue(mixed $value = null): static
    {
        $this->properties['value'] = $value;

        return $this;
    }

    /**
     * Get the custom field value
     *
     * @return mixed
     */
    public function getValue(): mixed
    {
        return $this->properties['value'] ?? null;
    }
}
