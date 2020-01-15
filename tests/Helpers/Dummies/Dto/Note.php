<?php

namespace Aedart\Tests\Helpers\Dummies\Dto;

use Aedart\Dto\Dto;
use Aedart\Tests\Helpers\Dummies\Contracts\Note as NoteInterface;

/**
 * Note
 *
 * FOR TESTING ONLY
 *
 * @property string $content
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Dto
 */
class Note extends Dto implements NoteInterface
{
    /**
     * This note's content
     *
     * @var string|null
     */
    protected ?string $content = null;

    /**
     * Set content
     *
     * @param string|null $content This note's content
     *
     * @return self
     */
    public function setContent(?string $content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string|null content or null if none content has been set
     */
    public function getContent(): ?string
    {
        return $this->content;
    }
}
