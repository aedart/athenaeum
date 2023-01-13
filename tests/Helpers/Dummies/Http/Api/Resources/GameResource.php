<?php

namespace Aedart\Tests\Helpers\Dummies\Http\Api\Resources;

use Aedart\Http\Api\Resources\ApiResource;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\Game;
use Illuminate\Http\Request;

/**
 * Game Resource
 *
 * @mixin Game
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Http\Api\Resources
 */
class GameResource extends ApiResource
{
    /**
     * @inheritDoc
     */
    public function __construct($resource)
    {
        parent::__construct($resource);

        $this->useSlugAsPrimaryKey();
    }

    /**
     * @inheritDoc
     */
    public function formatPayload(Request $request): array
    {
        return $this->withTimestamps([
            'slug' => $this->getSlugKey(),
            'name' => $this->name,
            'description' => $this->description,
            'owner' => $this->belongsToReference('owner'),
        ]);
    }

    /**
     * @inheritDoc
     */
    public function type(): string
    {
        return 'game';
    }
}
