<?php

namespace Aedart\Translation\Loaders;

use Aedart\Contracts\Translation\TranslationsLoader;
use Aedart\Support\Helpers\Translation\TranslationLoaderTrait;
use Illuminate\Contracts\Translation\Loader as NativeLoader;
use Symfony\Component\Finder\Finder;

/**
 * Raw Translations Loader
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Translation\Loaders
 */
class RawTranslationsLoader implements TranslationsLoader
{
    use TranslationLoaderTrait;

    /**
     * Paths to search in
     *
     * @var string[];
     */
    protected array $paths = [];

    /**
     * Creates a new raw translations loader instance
     *
     * @param NativeLoader|null $nativeLoader [optional] Laravel's native translations loader
     * @param string[] $paths [optional] Additional paths to search in
     */
    public function __construct(
        NativeLoader|null $nativeLoader = null,
        array $paths = [],
    ) {
        $this
            ->setTranslationLoader($nativeLoader)
            ->addPaths($paths);
    }

    /**
     * @inheritdoc
     */
    public function detectLocals(): array
    {
        $paths = $this->getPaths();

        return array_unique([
            ...$this->detectLocalesFromDirectories($paths),
            ...$this->detectLocalesFromJsonFilesIn($paths)
        ]);
    }

    /**
     * @inheritdoc
     */
    public function addPaths(string|array $paths): static
    {
        $paths = is_string($paths)
            ? [ $paths ]
            : $paths;

        return $this->setPaths(
            array_merge($this->getPaths(), $paths)
        );
    }

    /**
     * @inheritdoc
     */
    public function setPaths(array $paths): static
    {
        $this->paths = $paths;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getPaths(): array
    {
        // In case that more translation paths are added to the native
        // loader, then these must be merged here.

        return array_unique([
            ...$this->paths,
            ...$this->getNamespacePaths(),
            ...$this->getJsonPaths()
        ]);
    }

    /**
     * Get the namespace paths
     *
     * @return string[]
     */
    protected function getNamespacePaths(): array
    {
        return array_values($this->getTranslationLoader()->namespaces());
    }

    /**
     * Get the json paths
     *
     * @return string[]
     */
    protected function getJsonPaths(): array
    {
        $nativeLoader = $this->getTranslationLoader();

        if (!method_exists($nativeLoader, 'jsonPaths')) {
            return [];
        }

        return array_values($nativeLoader->jsonPaths());
    }

    /**
     * Detect locales from the names of the directories found in given paths
     *
     * @param string[] $paths
     *
     * @return string[] E.g. en, en-uk, fr, da... etc
     */
    protected function detectLocalesFromDirectories(array $paths): array
    {
        $locales = [];

        $found = Finder::create()
            ->in($paths)
            ->directories()
            ->depth(0)
            ->sortByName();

        foreach ($found as $item) {
            $locales[] = $item->getBasename();
        }

        return array_unique($locales);
    }

    /**
     * Detect locales from the json files' names in given paths
     *
     * @param string[] $paths
     *
     * @return string[] E.g. en, en-uk, fr, da... etc
     */
    protected function detectLocalesFromJsonFilesIn(array $paths): array
    {
        $locales = [];

        $found = Finder::create()
            ->files()
            ->name('*.json')
            ->ignoreDotFiles(true)
            ->in($paths)
            ->depth(0)
            ->sortByName();

        foreach ($found as $item) {
            $locales[] = $item->getBasename('.' . $item->getExtension());
        }

        return array_unique($locales);
    }
}
