<?php

namespace Aedart\Tests\Helpers\Dummies\Http\Api\Requests\Games;

use Aedart\Http\Api\Requests\Resources\DeleteSingleResourceRequest;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\Game;
use Illuminate\Database\Eloquent\Model;

/**
 * Delete Game Request
 *
 * FOR TESTING PURPOSES ONLY!
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Helpers\Dummies\Http\Api\Requests\Games
 */
class DeleteGameRequest extends DeleteSingleResourceRequest
{
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
    public function mustEvaluatePreconditions(): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function findRecordOrFail(): Model
    {
        $slug = $this->route('slug');

        // Include soft-deleted games, for tests...
        return Game::withTrashed()
            ->whereSlug($slug)
            ->sole();
    }
}
