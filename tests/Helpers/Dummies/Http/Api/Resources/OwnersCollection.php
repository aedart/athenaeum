<?php

namespace Aedart\Tests\Helpers\Dummies\Http\Api\Resources;

use Aedart\Http\Api\Resources\ApiResourceCollection;

/**
 * Owners Collection
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Http\Api\Resources
 */
class OwnersCollection extends ApiResourceCollection
{
    /**
     * @inheritDoc
     */
    public function resourceToCollect(): string
    {
        return OwnerResource::class;
    }
}