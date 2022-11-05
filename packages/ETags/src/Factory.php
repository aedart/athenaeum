<?php

namespace Aedart\ETags;

use Aedart\Contracts\ETags\Factory as ETagGeneratorFactory;
use Aedart\Contracts\ETags\Generator;
use Aedart\Contracts\Support\Helpers\Config\ConfigAware;
use Aedart\ETags\Exceptions\ProfileNotFound;
use Aedart\ETags\Generators\GenericGenerator;
use Aedart\Support\Helpers\Config\ConfigTrait;

/**
 * ETag Generator Factory
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags
 */
class Factory implements
    ETagGeneratorFactory,
    ConfigAware
{
    use ConfigTrait;

    /**
     * List of instantiated ETag Generators
     *
     * @var Generator[] Key = profile name, Value = Generator instance
     */
    protected array $generators = [];

    /**
     * @inheritDoc
     */
    public function profile(string|null $profile = null, array $options = []): Generator
    {
        $profile = $profile ?? $this->defaultProfile();

        // Use existing generator if already available
        if (isset($this->generators[$profile])) {
            return $this->generators[$profile];
        }

        return $this->generators[$profile] = $this->createGeneratorForProfile($profile, $options);
    }

    /**
     * @inheritDoc
     */
    public function generator(string|null $driver = null, array $options = []): Generator
    {
        $driver = $driver ?? $this->defaultGenerator();

        return new $driver($options);
    }

    /**
     * @inheritDoc
     */
    public function defaultGenerator(): string
    {
        return GenericGenerator::class;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Creates ETag Generator that matches given profile
     *
     * @param  string  $profile
     * @param  array  $options  [optional]
     *
     * @return Generator
     */
    protected function createGeneratorForProfile(string $profile, array $options = []): Generator
    {
        $configuration = $this->findOrFailProfileConfiguration($profile);
        $driver = $configuration['driver'] ?? null;
        $options = array_merge(
            $configuration['options'] ?? [],
            $options
        );

        return $this->generator($driver, $options);
    }

    /**
     * Find ETag generator profile configuration or fail
     *
     * @param  string  $profile
     *
     * @return array
     */
    protected function findOrFailProfileConfiguration(string $profile): array
    {
        $config = $this->getConfig();
        $key = 'etags.profiles.' . $profile;

        if (!$config->has($key)) {
            throw new ProfileNotFound(sprintf('Generator (profile) "%s" does not exist', $profile));
        }

        return $config->get($key);
    }

    /**
     * Returns name of the default ETag Generator "profile" to use
     *
     * @return string
     */
    protected function defaultProfile(): string
    {
        return $this->getConfig()->get('etags.default_generator', 'default');
    }
}