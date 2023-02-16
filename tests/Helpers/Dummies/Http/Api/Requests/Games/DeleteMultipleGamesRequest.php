<?php

namespace Aedart\Tests\Helpers\Dummies\Http\Api\Requests\Games;

use Aedart\Http\Api\Requests\Resources\ProcessMultipleResourcesRequest;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\Game;
use Illuminate\Database\Eloquent\Collection;

/**
 * Delete Multiple Games Request
 *
 * FOR TESTING PURPOSES ONLY!
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Helpers\Dummies\Http\Api\Requests\Games
 */
class DeleteMultipleGamesRequest extends ProcessMultipleResourcesRequest
{
    /**
     * @inheritDoc
     */
    public function configureValuesToAccept(): void
    {
        $this->acceptStringValues();
    }

    /**
     * @inheritDoc
     */
    public function authorizeFoundRecords(Collection $records): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function authorisationModel(): string|null
    {
        return Game::class;
    }
}
