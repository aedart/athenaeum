<?php

namespace Aedart\Tests\Helpers\Dummies\Http\Api\Resources;

use Aedart\Http\Api\Resources\ApiResource;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\Role;
use Illuminate\Http\Request;

/**
 * Role Resource
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @mixin Role
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Http\Api\Resources
 */
class RoleResource extends ApiResource
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
        return 'role';
    }
}