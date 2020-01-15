<?php

/*****************************************************************
 * FOR TESTING ONLY
 *
 * This application runs and logs a single entry.
 ****************************************************************/

/** @var \Aedart\Contracts\Core\Application $app */
$app = require_once 'bootstrap.php';

$app->run();

throw new \RuntimeException('Exception captured');
