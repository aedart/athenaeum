<?php

namespace Aedart\Tests\Helpers\Dummies\Http\Api\Requests\Users;

use Aedart\Http\Api\Requests\Resources\UpdateSingleResourceRequest;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Update User Request
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Http\Api\Requests\Users
 */
class UpdateUserRequest extends UpdateSingleResourceRequest
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

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:100'
        ];
    }
}
