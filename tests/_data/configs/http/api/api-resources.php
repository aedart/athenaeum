<?php

use Aedart\Tests\Helpers\Dummies\Http\Api\Models\Game;
use Aedart\Tests\Helpers\Dummies\Http\Api\Resources\GameResource;

return [

    /*
     |--------------------------------------------------------------------------
     | Api Resources
     |--------------------------------------------------------------------------
     |
     | A map of Eloquent Models and their associated Api Resource.
    */

    'registry' => [

        Game::class => GameResource::class,

    ],
];