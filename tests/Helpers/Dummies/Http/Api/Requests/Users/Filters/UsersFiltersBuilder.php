<?php

namespace Aedart\Tests\Helpers\Dummies\Http\Api\Requests\Users\Filters;

use Aedart\Filters\BaseBuilder;
use Aedart\Filters\Processors\SearchProcessor;
use Aedart\Filters\Processors\SortingProcessor;

/**
 * Users Filters Builder
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Http\Api\Requests\Users\Filters
 */
class UsersFiltersBuilder extends BaseBuilder
{
    /**
     * @inheritDoc
     */
    public function processors(): array
    {
        return [
            'search' => SearchProcessor::make()
                ->columns([ 'name' ]),

            'sort' => SortingProcessor::make()
                ->sortable([
                    'id',
                    'name',
                    'created_at',
                    'updated_at'
                ])
                ->force()
        ];
    }
}
