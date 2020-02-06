<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Commands
    |--------------------------------------------------------------------------
    |
    | List of your application's console commands. State the full class path to
    | the commands that you require to be available via the console.
    */

    \Aedart\Console\Commands\PirateTalkCommand::class,
    \Aedart\Tests\Helpers\Dummies\Console\Commands\FailsCommand::class,
    \Aedart\Tests\Helpers\Dummies\Console\Commands\DoesNothingCommand::class
];
