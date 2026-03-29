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
    public function setWidth(null|int $width = null);

    /**
     * Get width
     *
     * @return int|null
     */
    public function getWidth(): null|int;

    /**
     * Set height
     *
     * @param int|null $height [optional]
     *
     * @return self
     */
    public function setHeight(null|int $height = null);

    /**
     * Get height
     *
     * @return int|null
     */
    public function getHeight(): null|int;
}
