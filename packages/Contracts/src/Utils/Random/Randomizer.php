<?php

namespace Aedart\Contracts\Utils\Random;

/**
 * Randomizer
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Contracts\Utils\Random
 */
interface Randomizer extends
    StringRandomizer,
    NumericRandomizer,
    ArrayRandomizer
{
    /**
     * Returns the underlying driver of this randomizer
     *
     * @return mixed
     */
    public function driver(): mixed;
}
