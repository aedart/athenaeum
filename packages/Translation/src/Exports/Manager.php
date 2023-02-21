<?php

namespace Aedart\Translation\Exports;

use Aedart\Contracts\Support\Helpers\Config\ConfigAware;
use Aedart\Contracts\Translation\Exports\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\Translation\Exports\Exporter;
use Aedart\Contracts\Translation\Exports\Manager as ExportManager;
use Aedart\Support\Helpers\Config\ConfigTrait;
use Aedart\Translation\Exports\Drivers\ArrayExporter;
use Aedart\Translation\Exports\Exceptions\ProfileNotFound;

/**
 * Translations Export Manager
 *
 * @see \Aedart\Contracts\Translation\Exports\Manager
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Translation\Exports
 */
class Manager implements
    ExportManager,
    ConfigAware
{
    use ConfigTrait;

    /**
     * List of instantiated exporters
     *
     * @var Exporter[] Key = profile name, Value = Exporter instance
     */
    protected array $exporters = [];

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

        return new $driver($options);
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
        $options = array_merge(
            $configuration['options'] ?? [],
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
}