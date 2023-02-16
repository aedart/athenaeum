<?php

namespace Aedart\Tests\Helpers\Dummies\Http\Api\Requests\Users;

use Aedart\Http\Api\Requests\Resources\ShowSingleResourceRequest;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Show User Request
 *
 * FOR TESTING PURPOSES ONLY!
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Http\Api\Requests\Users
 */
class ShowUserRequest extends ShowSingleResourceRequest
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
        $id = $this->route('id');

        return User::findOrFail($id);
    }
}
