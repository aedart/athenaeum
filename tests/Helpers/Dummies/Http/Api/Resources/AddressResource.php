<?php

namespace Aedart\Tests\Helpers\Dummies\Http\Api\Resources;

use Aedart\Http\Api\Resources\ApiResource;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\Address;
use Illuminate\Http\Request;

/**
 * Address Resource
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @mixin Address
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Http\Api\Resources
 */
class AddressResource extends ApiResource
{
    /**
     * @inheritDoc
     */
    public function formatPayload(Request $request): array
    {
        return $this->withTimestamps([
            'id' => $this->getResourceKey(),
            'street' => $this->street,
            'postal_code' => $this->postal_code,
            'city' => $this->city
        ]);
    }

    /**
     * @inheritDoc
     */
    public function type(): string
    {
        return 'address';
    }
}
