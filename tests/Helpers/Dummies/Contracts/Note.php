<?php

namespace Aedart\Tests\Helpers\Dummies\Contracts;

/**
 * Note
 *
 * FOR TESTING ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Contracts
 */
interface Note
{
    /**
     * Set content
     *
     * @param string|null $content This note's content
     *
     * @return self
     */
    public function setContent(?string $content);

    /**
     * Get content
     *
     * @return string|null content or null if none content has been set
     */
    public function getContent(): ?string;
}
