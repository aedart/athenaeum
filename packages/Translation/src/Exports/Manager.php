<?php

namespace Aedart\Translation\Exports;

use Aedart\Contracts\Support\Helpers\Config\ConfigAware;
use Aedart\Contracts\Support\Helpers\Translation\TranslationLoaderAware;
use Aedart\Contracts\Translation\Exports\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\Translation\Exports\Exporter;
use Aedart\Contracts\Translation\Exports\Manager as ExportManager;
use Aedart\Support\Helpers\Config\ConfigTrait;
use Aedart\Support\Helpers\Translation\TranslationLoaderTrait;
use Aedart\Translation\Exports\Drivers\ArrayExporter;
use Aedart\Translation\Exports\Exceptions\ProfileNotFound;
use Illuminate\Contracts\Translation\Loader;

/**
 * Translations Exporter Manager
 *
 * @see \Aedart\Contracts\Translation\Exports\Manager
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Translation\Exports
 */
class Manager implements
    ExportManager,
    TranslationLoaderAware,
    ConfigAware
{
    use TranslationLoaderTrait;
    use ConfigTrait;

    /**
     * List of instantiated exporters
     *
     * @var Exporter[] Key = profile name, Value = Exporter instance
     */
    protected array $exporters = [];

    /**
     * Create a new translations export manager
     *
     * @param Loader|null $loader [optional]
     */
    public function __construct(Loader|null $loader = null)
    {
        $this->setTranslationLoader($loader);
    }

    /**
     * @inheritDoc
     */
    public function profile(?string $name = null, array $options = []): Exporter
    {
        $name = $name ?? $this->defaultProfile();

        if (isset($this->exporters[$name])) {
            return $this->exporters[$name];
        }

        return $this->exporters[$name] = $this->makeExporterForProfile($name, $options);
    }

    /**
     * @inheritDoc
     */
    public function exporter(string|null $driver = null, array $options = []): Exporter
    {
        $driver = $driver ?? $this->defaultExporter();

        return new $driver(
            $this->getTranslationLoader(),
            $options
        );
    }

    /**
     * @inheritDoc
     */
    public function defaultExporter(): string
    {
        return ArrayExporter::class;
    }

    /**
     * Returns name of the default exporter "profile" to use
     *
     * @return string
     */
    public function defaultProfile(): string
    {
        return $this->getConfig()->get('translations-exporter.default_exporter', 'default');
    }

    /**
     * Creates a new translations exporter instance for given profile
     *
     * @param string $profile
     * @param array $options [optional]
     *
     * @return Exporter
     *
     * @throws ProfileNotFoundException
     */
    protected function makeExporterForProfile(string $profile, array $options = []): Exporter
    {
        $configuration = $this->findProfileConfigurationOrFail($profile);
        $driver = $configuration['driver'] ?? null;

        $driverOptions = $configuration['options'] ?? [];
        if (!isset($driverOptions['paths'])) {
            $driverOptions['paths'] = $this->getPaths();
        }

        $options = array_merge(
            $driverOptions,
            $options
        );

        return $this->exporter($driver, $options);
    }

    /**
     * Find translations exporter profile configuration or fail
     *
     * @param string $profile
     *
     * @return array
     *
     * @throws ProfileNotFoundException
     */
    protected function findProfileConfigurationOrFail(string $profile): array
    {
        $config = $this->getConfig();
        $key = 'translations-exporter.profiles.' . $profile;

        if (!$config->has($key)) {
            throw new ProfileNotFound(sprintf('Exporter (profile) "%s" does not exist', $profile));
        }

        return $config->get($key);
    }

    /**
     * Returns paths in which locales and groups are located
     *
     * @return string[]
     */
    protected function getPaths(): array
    {
        return $this->getConfig()->get('translations-exporter.paths', [ lang_path() ]);
    }
}
