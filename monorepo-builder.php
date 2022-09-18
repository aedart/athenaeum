<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection;
use Symplify\MonorepoBuilder\ValueObject\Option;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\AddTagToChangelogReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\PushNextDevReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\PushTagReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\SetCurrentMutualDependenciesReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\SetNextMutualDependenciesReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\TagVersionReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\UpdateBranchAliasReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\UpdateReplaceReleaseWorker;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();

    // Set the default branch name (used to be "master")...
    $parameters->set(Option::DEFAULT_BRANCH_NAME, 'main');

    // Location of packages...etc
    $parameters->set(Option::PACKAGE_DIRECTORIES, [
        // default value
        __DIR__ . '/packages',
    ]);

    // Remove from root composer.json
    $parameters->set(Option::DATA_TO_REMOVE, [
        ComposerJsonSection::REQUIRE => [
            // the line is removed by key, so version is irrelevant, thus *
            'codeception/codeception' => '*',
            "codeception/module-asserts" => '*',
            'orchestra/testbench' => '*',
            'orchestra/testbench-dusk' => '*',
        ],
    ]);

    // Append to root composer.json
    $parameters->set(Option::DATA_TO_APPEND, [
        ComposerJsonSection::REQUIRE_DEV => [
            'ext-sockets' => '*',
            'ext-curl' => '*',
            'bamarni/composer-bin-plugin' => '^1.8.1',
            'roave/security-advisories' => 'dev-master',
            'codeception/codeception' => '^5.0.2',
            "codeception/module-asserts" => "^3.0.0",
            'orchestra/testbench' => '^v7.7.0',
            'orchestra/testbench-dusk' => '^v7.7.0',
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
//    $parameters->set(Option::PACKAGE_DIRECTORIES, [
//
//    ]);

    // Package alias format
    $parameters->set(Option::PACKAGE_ALIAS_FORMAT, '<major>.<minor>.x-dev');

    // Section order in composer.json files
    $parameters->set(Option::SECTION_ORDER, [
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

    $services = $containerConfigurator->services();

    # release workers - in order to execute
    $services->set(UpdateReplaceReleaseWorker::class);
    $services->set(SetCurrentMutualDependenciesReleaseWorker::class);
//    $services->set(AddTagToChangelogReleaseWorker::class);
    $services->set(TagVersionReleaseWorker::class);
    $services->set(PushTagReleaseWorker::class);
    $services->set(SetNextMutualDependenciesReleaseWorker::class);
    $services->set(UpdateBranchAliasReleaseWorker::class);
    $services->set(PushNextDevReleaseWorker::class);
};
