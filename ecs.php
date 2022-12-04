<?php

declare(strict_types=1);

use Symplify\EasyCodingStandard\Config\ECSConfig;
use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ECSConfig $config): void {
    // A. standalone rule
    $config->ruleWithConfiguration(ArraySyntaxFixer::class, [
        'syntax' => 'short',
    ]);

    // B. full sets
    $config->sets([
        SetList::CLEAN_CODE,
        SetList::PSR_12,
    ]);

    // Set paths
    $config->paths([
        'packages',
        'tests/Helpers',
        'tests/TestCases',
        'tests/Integration',
        'tests/Unit',
        'tests/Helpers',
        //'src',
    ]);

    // Skip
    $config->skip([
        SlevomatCodingStandard\Sniffs\Classes\UnusedPrivateElementsSniff::class . '.UnusedProperty' => [
            # The "private int $height" is used by Dto, via magic methods...
            'tests/Helpers/Dummies/Properties/Accessibility/Person.php'
        ]
    ]);

    // Run all checks parallel (should be much faster)
    $config->parallel();
};
