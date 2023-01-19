<?php

namespace Aedart\Tests\Helpers\Dummies\Http\Api\Requests\Games;

use Aedart\Http\Api\Requests\Resources\ListDeletedResourcesRequest;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\Game;
use Aedart\Tests\Helpers\Dummies\Http\Api\Requests\Games\Filters\GamesFiltersBuilder;

/**
 * List Deleted Games Request
 *
 * FOR TESTING PURPOSES ONLY!
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Helpers\Dummies\Http\Api\Requests\Games
 */
class ListDeletedGamesRequest extends ListDeletedResourcesRequest
{
    /**
     * @inheritdoc
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function filtersBuilder(): string|null
    {
        return GamesFiltersBuilder::class;
    }

    /**
     * @inheritDoc
     */
    public function authorisationModel(): string|null
    {
        return Game::class;
    }
}
