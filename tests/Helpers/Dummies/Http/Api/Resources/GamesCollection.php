<?php

namespace Aedart\Tests\Helpers\Dummies\Http\Api\Resources;

use Aedart\Http\Api\Resources\ApiResourceCollection;

/**
 * Games Collection
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Http\Api\Resources
 */
class GamesCollection extends ApiResourceCollection
{
    /**
     * @inheritDoc
     */
    public function resourceToCollect(): string
    {
        return GameResource::class;
    }
}