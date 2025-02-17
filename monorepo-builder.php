<?php

declare(strict_types=1);

use Symplify\MonorepoBuilder\Config\MBConfig;
use Symplify\MonorepoBuilder\ComposerJsonManipulator\ValueObject\ComposerJsonSection;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\PushNextDevReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\PushTagReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\SetCurrentMutualDependenciesReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\SetNextMutualDependenciesReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\TagVersionReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\UpdateBranchAliasReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\UpdateReplaceReleaseWorker;

/**
 * Mono-repository configuration
 *
 * @see https://github.com/symplify/monorepo-builder
 */
return static function (MBConfig $config): void {

    // Set the default branch name (used to be "master")...
    $config->defaultBranch('main');

    // Location of packages...etc
    $config->packageDirectories([
        // default value
        __DIR__ . '/packages',
    ]);

    // Remove from root composer.json
    $config->dataToRemove([
        ComposerJsonSection::REQUIRE => [
            // the line is removed by key, so version is irrelevant, thus *
            'codeception/codeception' => '*',
            "codeception/module-asserts" => '*',
            'orchestra/testbench' => '*',
            'orchestra/testbench-dusk' => '*',
            'illuminate/testing' => '*'
        ],
    ]);

    // Append to root composer.json
    $config->dataToAppend([
        ComposerJsonSection::REQUIRE_DEV => [
            'ext-sockets' => '*',
            'ext-curl' => '*',
            'bamarni/composer-bin-plugin' => '^1.8.2',
            'roave/security-advisories' => 'dev-master',
            'codeception/codeception' => '^5.2.0',
            "codeception/module-asserts" => "^3.0.0",
            'orchestra/testbench' => '^v9.10.0',
            'orchestra/testbench-dusk' => '^v9.12.1',
            'illuminate/testing' => '^v11.42.1'
        ],

        ComposerJsonSection::AUTOLOAD => [
            'psr-4' => [
                'Aedart\\' => 'src',
            ],
        ],

        ComposerJsonSection::AUTOLOAD_DEV => [
//            'psr-4' => [
//                'phpstan/phpstan\\' => '^0.12',
//            ],
        ],
    ]);

    // Packages
//    $config->packageDirectories([
//
//    ]);

    // Package alias format
    $config->packageAliasFormat('<major>.<minor>.x-dev');

    // Section order in composer.json files
    $config->composerSectionOrder([
        'name',
        'type',
        'description',
        'keywords',
        'homepage',
        'support',
        'license',
        'authors',
        'repositories',
        'require',
        'require-dev',
        'autoload',
        'autoload-dev',
        'replace',
        'provide',
        'bin',
        'conflict',
        'suggest',
        'scripts',
        'scripts-descriptions',
        'config',
        'minimum-stability',
        'prefer-stable',
        'extra',
    ]);

    /*****************************************************************
     * Release Workers
     ****************************************************************/

    $config->workers([
        UpdateReplaceReleaseWorker::class,
        SetCurrentMutualDependenciesReleaseWorker::class,
        // AddTagToChangelogReleaseWorker::class,
        TagVersionReleaseWorker::class,
        PushTagReleaseWorker::class,
        SetNextMutualDependenciesReleaseWorker::class,
        UpdateBranchAliasReleaseWorker::class,
        PushNextDevReleaseWorker::class,
    ]);
};
