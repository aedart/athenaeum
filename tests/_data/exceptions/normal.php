<?php

/*****************************************************************
 * FOR TESTING ONLY
 *
 * This application runs and logs a single entry.
 ****************************************************************/

/** @var \Aedart\Contracts\Core\Application $app */
$app = require_once 'bootstrap.php';

$app->run(function(\Aedart\Contracts\Core\Application $application){

    /** @var \Psr\Log\LoggerInterface $log */
    $log = $application['log'];

    $log->info('normal application works');

    echo 'ok';
});

$app->terminate();

$app->destroy();
