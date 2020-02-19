<?php

namespace Aedart\Tests\Helpers\Dummies\Contracts;

/**
 * Box
 *
 * FOR TESTING ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Contracts
 */
interface Box
{
    /**
     * Set width
     *
     * @param int|null $width [optional]
     *
     * @return self
     */
    public function setWith(?int $width = null);

    /**
     * Get width
     *
     * @return int|null
     */
    public function getWidth(): ?int;

    /**
     * Set height
     *
     * @param int|null $height [optional]
     *
     * @return self
     */
    public function setHeight(?int $height = null);

    /**
     * Get height
     *
     * @return int|null
     */
    public function getHeight(): ?int;
}
