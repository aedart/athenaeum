<?php

declare(strict_types=1);

use Symplify\EasyCodingStandard\Config\ECSConfig;
use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use PhpCsFixer\Fixer\LanguageConstruct\NullableTypeDeclarationFixer;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ECSConfig $config): void {
    // A. standalone rules
    $config->rulesWithConfiguration([
        ArraySyntaxFixer::class => [
            'syntax' => 'short',
        ],
        NullableTypeDeclarationFixer::class => [
            'syntax' => 'union'
        ]
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
