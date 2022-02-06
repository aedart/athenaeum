<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection;
use Symplify\MonorepoBuilder\ValueObject\Option;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();

    // Location of packages...etc
    $parameters->set(Option::PACKAGE_DIRECTORIES, [
        // default value
        __DIR__ . '/packages',
    ]);

    // Remove from root composer.json
    $parameters->set(Option::DATA_TO_REMOVE, [
        ComposerJsonSection::REQUIRE => [
            // the line is removed by key, so version is irrelevant, thus *
            'hanneskod/classtools' => '*',
            'codeception/codeception' => '*',
            'codeception/module-asserts' => '*',
            'orchestra/testbench' => '*',
            'orchestra/testbench-dusk' => '*',
        ],
    ]);

    // Append to root composer.json
    $parameters->set(Option::DATA_TO_APPEND, [
        ComposerJsonSection::REQUIRE_DEV => [
            'ext-sockets' => '*',
            'ext-curl' => '*',
            'bamarni/composer-bin-plugin' => '^1.4',
            'roave/security-advisories' => 'dev-master',
            'codeception/codeception' => '5.0.0-alpha1',
            'codeception/module-asserts' => '*@dev',
            'orchestra/testbench' => '7.x-dev',
            'orchestra/testbench-dusk' => 'dev-master',
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
};
