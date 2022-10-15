<?php

namespace Aedart\Tests\Helpers\Dummies\Http\Api\Resources;

use Illuminate\Http\Request;

/**
 * Alternative Game Resource
 *
 * FOR TESTING PURPOSES ONLY!
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Http\Api\Resources
 */
class AlternativeGameResource extends GameResource
{
    /**
     * @inheritDoc
     */
    public function formatPayload(Request $request): array
    {
        return [
            'slug' => $this->getSlugKey(),
            'name' => $this->name,
            'description' => $this->description,
            'timestamps' => $this->withTimestamps()
        ];
    }
}