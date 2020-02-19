<?php

namespace Aedart\Support\Properties\Strings;

/**
 * Type Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\TypeAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait TypeTrait
{
    /**
     * Type identifier
     *
     * @var string|null
     */
    protected ?string $type = null;

    /**
     * Set type
     *
     * @param string|null $identifier Type identifier
     *
     * @return self
     */
    public function setType(?string $identifier)
    {
        $this->type = $identifier;

        return $this;
    }

    /**
     * Get type
     *
     * If no "type" value set, method
     * sets and returns a default "type".
     *
     * @see getDefaultType()
     *
     * @return string|null type or null if no type has been set
     */
    public function getType(): ?string
    {
        if (!$this->hasType()) {
            $this->setType($this->getDefaultType());
        }
        return $this->type;
    }

    /**
     * Check if "type" has been set
     *
     * @return bool True if "type" has been set, false if not
     */
    public function hasType(): bool
    {
        return isset($this->type);
    }

    /**
     * Get a default "type" value, if any is available
     *
     * @return string|null Default "type" value or null if no default value is available
     */
    public function getDefaultType(): ?string
    {
        return null;
    }
}
