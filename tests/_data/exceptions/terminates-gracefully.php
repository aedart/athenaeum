<?php

/*****************************************************************
 * FOR TESTING ONLY
 *
 * This application runs and logs a single entry.
 ****************************************************************/

/** @var \Aedart\Contracts\Core\Application $app */
$app = require_once 'bootstrap.php';

$app->terminating(function(){
    dump('Terminating...');
});

$app->run(function(){
    throw new \Aedart\Tests\Helpers\Dummies\Core\Exceptions\SpecialException();
});

$app->terminate();
$app->destroy();



