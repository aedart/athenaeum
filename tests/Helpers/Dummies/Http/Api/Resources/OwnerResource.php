<?php

namespace Aedart\Tests\Helpers\Dummies\Http\Api\Resources;

use Aedart\Http\Api\Resources\ApiResource;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\Owner;
use Illuminate\Http\Request;

/**
 * Owner Resource
 *
 * @mixin Owner
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Http\Api\Resources
 */
class OwnerResource extends ApiResource
{
    /**
     * @inheritDoc
     */
    public static function collectionResource(): string
    {
        return OwnersCollection::class;
    }

    /**
     * @inheritDoc
     */
    public function formatPayload(Request $request): array
    {
        return $this->withTimestamps([
            'id' => $this->getKey(),
            'name' => $this->name,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function type(): string
    {
        return 'owner';
    }
}