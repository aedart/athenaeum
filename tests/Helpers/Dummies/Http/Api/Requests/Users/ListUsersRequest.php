<?php

namespace Aedart\Tests\Helpers\Dummies\Http\Api\Requests\Users;

use Aedart\Contracts\Filters\Builder;
use Aedart\Http\Api\Requests\Resources\ListResourcesRequest;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\User;
use Aedart\Tests\Helpers\Dummies\Http\Api\Requests\Users\Filters\UsersFiltersBuilder;

/**
 * List Users Request
 *
 * FOR TESTING PURPOSES ONLY!
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Helpers\Dummies\Http\Api\Requests\Users
 */
class ListUsersRequest extends ListResourcesRequest
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
    public function filtersBuilder(): string|Builder|null
    {
        return UsersFiltersBuilder::class;
    }

    /**
     * @inheritDoc
     */
    public function authorisationModel(): string|null
    {
        return User::class;
    }
}
