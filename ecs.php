<?php

declare(strict_types=1);

use Symplify\EasyCodingStandard\Config\ECSConfig;
use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use PhpCsFixer\Fixer\LanguageConstruct\NullableTypeDeclarationFixer;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return ECSConfig::configure()
    // A. standalone rules
    ->withConfiguredRule(
        ArraySyntaxFixer::class,
        [
            'syntax' => 'short'
        ]
    )
    ->withConfiguredRule(
        NullableTypeDeclarationFixer::class,
        [
            'syntax' => 'union'
        ]
    )

    // B. full sets
    ->withSets([
        SetList::CLEAN_CODE,
        SetList::PSR_12,
    ])

    // Set paths
    ->withPaths([
        'packages',
        'tests/Helpers',
        'tests/TestCases',
        'tests/Integration',
        'tests/Unit',
        //'src',
    ])

    // Skip
    ->withSkip([
        \SlevomatCodingStandard\Sniffs\Classes\UnusedPrivateElementsSniff::class . '.UnusedProperty' => [
            # The "private int $height" is used by Dto, via magic methods...
            'tests/Helpers/Dummies/Properties/Accessibility/Person.php'
        ]
    ])

    // Run all checks parallel (should be much faster)
    ->withParallel();