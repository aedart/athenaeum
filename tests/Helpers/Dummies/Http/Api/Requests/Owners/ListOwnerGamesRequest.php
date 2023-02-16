<?php

namespace Aedart\Tests\Helpers\Dummies\Http\Api\Requests\Owners;

use Aedart\Contracts\Filters\Builder;
use Aedart\Http\Api\Requests\Resources\ListRelatedResourcesRequest;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\Game;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\Owner;
use Aedart\Tests\Helpers\Dummies\Http\Api\Requests\Games\Filters\GamesFiltersBuilder;
use Illuminate\Database\Eloquent\Model;

/**
 * List Owner Games Request
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Http\Api\Requests\Owners
 */
class ListOwnerGamesRequest extends ListRelatedResourcesRequest
{
    /**
     * @inheritDoc
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function authorizeFoundRecord(Model $record): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function filtersBuilder(): string|Builder|null
    {
        return GamesFiltersBuilder::make($this);
    }

    /**
     * @inheritDoc
     */
    public function authorisationModel(): string|null
    {
        return Game::class;
    }

    /**
     * @inheritDoc
     */
    public function findRecordOrFail(): Model
    {
        $id = $this->route('id');

        return Owner::findOrFail($id);
    }
}
