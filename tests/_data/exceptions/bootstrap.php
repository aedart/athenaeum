<?php

/*****************************************************************
 * FOR TESTING ONLY
 *
 * Bootstrap loads autoloader and creates a new application.
 ****************************************************************/

// Load composer autoload
if(file_exists(__DIR__ . '/../../../vendor/autoload.php')){
    require_once __DIR__ . '/../../../vendor/autoload.php';
}

/*****************************************************************
 * Setup paths
 ****************************************************************/

$paths = [
    'basePath'          => __DIR__,
    'configPath'        => __DIR__ . '/configs',
    'environmentPath'   => __DIR__,
    'storagePath'       => __DIR__ . '/../../_output/exceptions/storage'
];

if( ! is_dir($paths['storagePath'])){
    mkdir($paths['storagePath'], 0755, true);
}

/*****************************************************************
 * Create app instance
 ****************************************************************/

return new \Aedart\Core\Application($paths, 'x.x.x-dev');
