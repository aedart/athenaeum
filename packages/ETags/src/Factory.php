<?php

namespace Aedart\ETags;

use Aedart\Contracts\ETags\Collection;
use Aedart\Contracts\ETags\ETag as ETagInterface;
use Aedart\Contracts\ETags\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\ETags\Factory as ETagGeneratorFactory;
use Aedart\Contracts\ETags\Generator;
use Aedart\Contracts\Support\Helpers\Config\ConfigAware;
use Aedart\ETags\Exceptions\ProfileNotFound;
use Aedart\ETags\Generators\GenericGenerator;
use Aedart\Support\Facades\IoCFacade;
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

    /**
     * @inheritDoc
     */
    public function parse(string $rawHeaderValue): Collection
    {
        $class = $this->eTagClass();

        return $class::parse($rawHeaderValue);
    }

    /**
     * @inheritDoc
     */
    public function parseSingle(string $value): ETagInterface
    {
        $class = $this->eTagClass();

        return $class::parseSingle($value);
    }

    /**
     * @inheritdoc
     */
    public function makeRaw(string $rawValue, bool $isWeak = false): ETagInterface
    {
        $class = $this->eTagClass();

        return $class::make($rawValue, $isWeak);
    }

    /**
     * Dynamically call the default "profile" generator instance.
     *
     * @param  string  $method
     * @param  array  $parameters
     *
     * @return mixed
     *
     * @throws ProfileNotFoundException
     */
    public function __call(string $method, array $parameters): mixed
    {
        return $this->profile()->$method(...$parameters);
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Returns class path to ETag
     *
     * @return string
     */
    protected function eTagClass(): string
    {
        // Obtain class path from service container or default.
        // Note: full namespace SHOULD be used here to avoid import issues
        return IoCFacade::tryMake('etag_class', \Aedart\ETags\ETag::class);
    }

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
