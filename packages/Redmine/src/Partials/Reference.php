<?php

namespace Aedart\Redmine\Partials;

use Aedart\Dto\ArrayDto;

/**
 * Resource Reference
 *
 * @property string|int|null $id
 * @property string $name
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Redmine\Partials
 */
class Reference extends ArrayDto
{
    protected array $allowed = [
        'id' => 'string', // type ignore - see getter / setter
        'name' => 'string'
    ];

    /**
     * Set the reference's id
     *
     * @param string|int|null $id
     *
     * @return self
     */
    public function setId(string|int|null $id = null): static
    {
        $this->properties['id'] = $id;

        return $this;
    }

    /**
     * Get the reference's id
     *
     * @return string|int|null
     */
    public function getId(): string|int|null
    {
        return $this->properties['id'] ?? null;
    }
}
