<?php

namespace Aedart\Translation\Exports\Drivers;

use Aedart\Contracts\Translation\Exports\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\Translation\Exports\Exporter;
use Aedart\Support\Helpers\Cache\CacheFactoryTrait;
use Aedart\Translation\Traits\TranslationsExporterManagerTrait;
use DateInterval;
use DateTimeInterface;
use Illuminate\Contracts\Cache\Repository;

/**
 * Cache Exporter
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Translation\Exports\Drivers
 */
class CacheExporter extends BaseExporter
{
    use TranslationsExporterManagerTrait;
    use CacheFactoryTrait;

    /**
     * @inheritDoc
     */
    public function performExport(array $paths, array $locales, array $groups): mixed
    {
        $key = $this->key();
        $ttl = $this->ttl();

        return $this->cache()->remember($key, $ttl, function () use ($locales, $groups) {
            return $this->makeExporter()->export($locales, $groups);
        });
    }

    /**
     * Returns the exporter to be used
     *
     * @return Exporter
     *
     * @throws ProfileNotFoundException
     */
    public function makeExporter(): Exporter
    {
        $profile = $this->exporterProfile();

        return $this
            ->getTranslationsExporterManager()
            ->profile($profile);
    }

    /**
     * Returns the exporter profile
     *
     * @return string
     */
    public function exporterProfile(): string
    {
        return $this->options['exporter'] ?? 'default';
    }

    /**
     * Returns the cache repository
     *
     * @return Repository
     */
    public function cache(): Repository
    {
        $store = $this->options['cache'] ?? 'file';

        return $this->getCacheFactory()->store($store);
    }

    /**
     * Get Time-to-live for cached translations
     *
     * @return DateTimeInterface|DateInterval|int|null
     */
    public function ttl(): DateTimeInterface|DateInterval|int|null
    {
        return $this->options['ttl'] ?? 3600;
    }

    /**
     * Returns the cache key
     *
     * @return string
     */
    public function key(): string
    {
        $prefix = $this->options['prefix'] ?? 'trans_export_';
        $key = $this->exporterProfile();

        return "{$prefix}{$key}";
    }

    /**
     * @inheritdoc
     */
    public function jsonKey(): string
    {
        return $this->makeExporter()->jsonKey();
    }
}
