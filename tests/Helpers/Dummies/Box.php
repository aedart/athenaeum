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

    protected $width;
    protected $height;

    /**
     * {@inheritdoc}
     */
    public function setWith(?int $width = null)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getWidth(): ?int
    {
        return $this->width;
    }

    /**
     * {@inheritdoc}
     */
    public function setHeight(?int $height = null)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeight(): ?int
    {
        return $this->height;
    }
}
