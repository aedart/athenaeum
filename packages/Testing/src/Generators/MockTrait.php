<?php

namespace Aedart\Testing\Generators;

use LogicException;

/**
 * Mock Trait Generator
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Testing\Generators
 */
class MockTrait
{
    /**
     * Creates a new Mock Trait instance
     *
     * @param class-string $trait
     */
    public function __construct(
        protected string $trait
    ) {
        if (!trait_exists($this->trait, false)) {
            throw new LogicException(sprintf('%s is either not a trait or it does not exist', $this->trait));
        }
    }

    /**
     * Generates a new class that uses specified trait
     *
     * @return string
     */
    public function generate(): string
    {
        $trait = $this->trait;
        $name = $this->makeClassname($trait);
        $template = $this->render($name, $trait);

        if (!class_exists($name, false)) {
            eval($template);
        }

        return $name;
    }

    /**
     * Generates a new classname for given trait
     *
     * @param string $trait
     *
     * @return string
     */
    public function makeClassname(string $trait): string
    {
        $path = str_replace('\\', '_', $trait);

        return "Mocked_Trait_{$path}";
    }

    /**
     * Renders a new class that uses given trait
     *
     * @param string $name Class name
     * @param class-string $trait
     *
     * @return string
     */
    public function render(string $name, string $trait): string
    {
        return "
            declare(strict_types=1);

            class {$name} {
                use {$trait};
            }
        ";
    }
}
