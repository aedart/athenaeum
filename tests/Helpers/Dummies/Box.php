<?php

namespace Aedart\Tests\Helpers\Dummies;

use Aedart\Tests\Helpers\Dummies\Contracts\Box as BoxInterface;

/**
 * Box
 *
 * FOR TESTING ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies
 */
class Box implements BoxInterface
{
    protected null|int $width;
    protected null|int $height;

    /**
     * {@inheritdoc}
     */
    public function setWidth(null|int $width = null)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getWidth(): null|int
    {
        return $this->width;
    }

    /**
     * {@inheritdoc}
     */
    public function setHeight(null|int $height = null)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeight(): null|int
    {
        return $this->height;
    }
}
