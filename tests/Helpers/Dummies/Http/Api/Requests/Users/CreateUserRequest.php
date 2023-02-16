<?php

namespace Aedart\Tests\Helpers\Dummies\Http\Api\Requests\Users;

use Aedart\Http\Api\Requests\Resources\CreateSingleResourceRequest;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\User;

/**
 * Create User Request
 *
 * FOR TESTING PURPOSES ONLY!
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Http\Api\Requests\Users
 */
class CreateUserRequest extends CreateSingleResourceRequest
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
    public function mustEvaluatePreconditions(): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function authorisationModel(): string|null
    {
        return User::class;
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
