<?php

/*****************************************************************
 * FOR TESTING ONLY
 *
 * This application runs and logs a single entry.
 ****************************************************************/

/** @var \Aedart\Contracts\Core\Application $app */
$app = require_once 'bootstrap.php';

$app->run();

trigger_error('Custom PHP Error captured', E_USER_WARNING);
