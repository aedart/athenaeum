<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ContainerConfigurator $containerConfigurator): void {
    // A. standalone rule
    $services = $containerConfigurator->services();
    $services->set(ArraySyntaxFixer::class)
        ->call('configure', [[
            'syntax' => 'short',
        ]]);

    // B. full sets
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::SETS, [
        SetList::CLEAN_CODE,
        SetList::PSR_12,
    ]);

    // Set paths
    $parameters->set(Option::PATHS, [
        'packages',
        'tests/Helpers',
        'tests/TestCases',
        'tests/Integration',
        'tests/Unit',
        'tests/Helpers',
        //'src',
    ]);

    // Skip
    $parameters->set(Option::SKIP, [

        SlevomatCodingStandard\Sniffs\Classes\UnusedPrivateElementsSniff::class . '.UnusedProperty' => [
            # The "private int $height" is used by Dto, via magic methods...
            'tests/Helpers/Dummies/Properties/Accessibility/Person.php'
        ]
    ]);

    // Run all checks parallel (should be much faster)
    $parameters->set(Option::PARALLEL, true);
};
