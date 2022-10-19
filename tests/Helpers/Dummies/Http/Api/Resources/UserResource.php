<?php

namespace Aedart\Tests\Helpers\Dummies\Http\Api\Resources;

use Aedart\Http\Api\Resources\ApiResource;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\User;
use Illuminate\Http\Request;

/**
 * User Resource
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @mixin User
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Http\Api\Resources
 */
class UserResource extends ApiResource
{

    /**
     * @inheritDoc
     */
    public function formatPayload(Request $request): array
    {
        return $this->withTimestamps([
            'id' => $this->getResourceKey(),
            'name' => $this->name
        ]);
    }

    /**
     * @inheritDoc
     */
    public function type(): string
    {
        return 'user';
    }
}