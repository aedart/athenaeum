<?php

namespace Aedart\Antivirus;

use Aedart\Antivirus\Exceptions\ProfileNotFound;
use Aedart\Antivirus\Scanners\ClamAv;
use Aedart\Contracts\Antivirus\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\Antivirus\Manager as AntivirusManager;
use Aedart\Contracts\Antivirus\Scanner;
use Aedart\Contracts\Support\Helpers\Config\ConfigAware;
use Aedart\Contracts\Support\Helpers\Events\DispatcherAware;
use Aedart\Support\Helpers\Config\ConfigTrait;
use Aedart\Support\Helpers\Events\DispatcherTrait;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Events\Dispatcher;

/**
 * Antivirus Scanner Manager
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Antivirus
 */
class Manager implements
    AntivirusManager,
    DispatcherAware,
    ConfigAware
{
    use DispatcherTrait;
    use ConfigTrait;

    /**
     * List of instantiated scanners
     *
     * @var Scanner[] Key = profile name, Value = Scanner instance
     */
    protected array $scanners = [];

    /**
     * Create a new antivirus manager
     *
     * @param Dispatcher|null $dispatcher [optional]
     * @param Repository|null $repository [optional]
     */
    public function __construct(
        Dispatcher|null $dispatcher = null,
        Repository|null $repository = null
    ) {
        $this
            ->setDispatcher($dispatcher)
            ->setConfig($repository);
    }

    /**
     * @inheritDoc
     */
    public function profile(string|null $name = null, array $options = []): Scanner
    {
        $name = $name ?? $this->defaultProfile();

        if (isset($this->scanners[$name])) {
            return $this->scanners[$name];
        }

        return $this->scanners[$name] = $this->makeScannerForProfile($name, $options);
    }

    /**
     * @inheritDoc
     */
    public function scanner(string|null $driver = null, array $options = []): Scanner
    {
        $driver = $driver ?? $this->defaultScanner();
        $profile = $options['profile'] ?? null;

        return new $driver(
            $this->getDispatcher(),
            $profile,
            $options
        );
    }

    /**
     * @inheritDoc
     */
    public function defaultScanner(): string
    {
        return ClamAv::class;
    }

    /**
     * Returns name of the default scanner "profile" to use
     *
     * @return string
     */
    public function defaultProfile(): string
    {
        return $this->getConfig()->get('antivirus.default_scanner', 'default');
    }

    /**
     * Forwards dynamic calls to scanner (default profile)
     *
     * @param string $name Method name
     * @param array $arguments
     *
     * @return mixed
     *
     * @throws ProfileNotFoundException
     */
    public function __call(string $name, array $arguments): mixed
    {
        return $this->profile()->$name(...$arguments);
    }

    /**
     * Creates a new antivirus scanner instance for given profile
     *
     * @param string $profile
     * @param array $options [optional]
     *
     * @return Scanner
     *
     * @throws ProfileNotFoundException
     */
    protected function makeScannerForProfile(string $profile, array $options = []): Scanner
    {
        $configuration = $this->findProfileConfigurationOrFail($profile);
        $driver = $configuration['driver'] ?? null;

        $options = array_merge(
            [ 'profile' => $profile ],
            $configuration['options'] ?? [],
            $options
        );

        return $this->scanner($driver, $options);
    }

    /**
     * Find scanner profile configuration or fail
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
        $key = 'antivirus.profiles.' . $profile;

        if (!$config->has($key)) {
            throw new ProfileNotFound(sprintf('Antivirus Scanner (profile) "%s" does not exist', $profile));
        }

        return $config->get($key);
    }
}
