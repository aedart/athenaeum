<?php

/*****************************************************************
 * FOR TESTING ONLY
 *
 * This application runs and logs a single entry.
 ****************************************************************/

/** @var \Aedart\Contracts\Core\Application $app */
$app = require_once 'bootstrap.php';

$app->run();

// Easiest way to trigger a failure during shutdown, is to trigger an error,
// whilst suppressing it's output. This will be picked up by the "error_get_last()"
// method...
@trigger_error('Shutdown error captured', E_USER_WARNING);
