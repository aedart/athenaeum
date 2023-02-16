<?php

namespace Aedart\Tests\Helpers\Dummies\Http\Api\Requests\Games\Filters;

use Aedart\Filters\BaseBuilder;
use Aedart\Filters\Processors\SearchProcessor;
use Aedart\Filters\Processors\SortingProcessor;

/**
 * Games Filters Builder
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Helpers\Dummies\Http\Api\Requests\Games\Filters
 */
class GamesFiltersBuilder extends BaseBuilder
{
    /**
     * @inheritDoc
     */
    public function processors(): array
    {
        return [
            'search' => SearchProcessor::make()
                ->columns([
                    'slug',
                    'name',
                    'description'
                ]),

            'sort' => SortingProcessor::make()
                ->sortable([
                    'id',
                    'slug',
                    'name',
                    'description',
                    'created_at',
                    'updated_at',
                    'deleted_at'
                ])
                ->force()
        ];
    }
}
