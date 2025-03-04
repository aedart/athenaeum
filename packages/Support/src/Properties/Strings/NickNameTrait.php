<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Nick name Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\NickNameAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait NickNameTrait
{
    /**
     * Nickname of someone or something
     *
     * @var string|null
     */
    protected string|null $nickName = null;

    /**
     * Set nick name
     *
     * @param string|null $name Nickname of someone or something
     *
     * @return self
     */
    public function setNickName(string|null $name): static
    {
        $this->nickName = $name;

        return $this;
    }

    /**
     * Get nick name
     *
     * If no nick name value set, method
     * sets and returns a default nick name.
     *
     * @see getDefaultNickName()
     *
     * @return string|null nick name or null if no nick name has been set
     */
    public function getNickName(): string|null
    {
        if (!$this->hasNickName()) {
            $this->setNickName($this->getDefaultNickName());
        }
        return $this->nickName;
    }

    /**
     * Check if nick name has been set
     *
     * @return bool True if nick name has been set, false if not
     */
    public function hasNickName(): bool
    {
        return isset($this->nickName);
    }

    /**
     * Get a default nick name value, if any is available
     *
     * @return string|null Default nick name value or null if no default value is available
     */
    public function getDefaultNickName(): string|null
    {
        return null;
    }
}
