<?php

namespace Aedart\Service;

use Aedart\Contracts\Service\Registrar as RegistrarInterface;
use Aedart\Support\Helpers\Foundation\AppTrait;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

/**
 * Service Provider Registrar
 *
 * @see \Aedart\Contracts\Service\Registrar
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Service
 */
class Registrar implements RegistrarInterface
{
    use AppTrait;

    /**
     * List of registered service providers
     *
     * @var ServiceProvider[]
     */
    protected array $registered = [];

    /**
     * List of booted service providers
     *
     * @var ServiceProvider[]
     */
    protected array $booted = [];

    /**
     * Registrar constructor.
     *
     * @param Application|null $application [optional]
     */
    public function __construct(Application|null $application = null)
    {
        $this->setApp($application);
    }

    /**
     * @inheritDoc
     */
    public function register($provider, bool $boot = true): bool
    {
        // Abort if already registered and not forced to register
        if ($this->isRegistered($provider)) {
            return false;
        }

        // Create provider instance or return given
        $provider = $this->resolveProvider($provider);

        // Register provider and it's internal bindings & singletons
        $this->performRegistration($provider);

        // Boot provider if required
        if ($boot) {
            $this->boot($provider);
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function registerMultiple(array $providers, bool $boot = true, bool $safeBoot = true): void
    {
        // If invoked with "safe boot false", then we must boot
        // each provider immediately, during it's registration
        $shouldBootImmediately = $boot && !$safeBoot;

        foreach ($providers as $provider) {
            $this->register($provider, $shouldBootImmediately);
        }

        if ($boot && $safeBoot) {
            // We have to boot instances registered, not given
            // list of providers, which might just be class paths!
            $this->bootMultiple($this->providers());
        }
    }

    /**
     * @inheritdoc
     */
    public function boot($provider): bool
    {
        if ($this->hasBooted($provider)) {
            return false;
        }

        $hasBooted = false;

        $provider->callBootingCallbacks();

        // Invoke boot on provider in the same was that Laravel's Application does it...
        // @see \Illuminate\Foundation\Application::bootProvider
        if (method_exists($provider, 'boot')) {
            $this->getApp()->call([$provider, 'boot']);
            $this->markAsBooted($provider);
            $hasBooted = true;
        }

        $provider->callBootedCallbacks();

        return $hasBooted;
    }

    /**
     * @inheritdoc
     */
    public function bootMultiple(array $providers): void
    {
        array_walk($providers, function (ServiceProvider $provider) {
            $this->boot($provider);
        });
    }

    /**
     * @inheritdoc
     */
    public function bootAll(): void
    {
        $this->bootMultiple($this->providers());
    }

    /**
     * @inheritdoc
     */
    public function isRegistered($provider): bool
    {
        $registered = $this->getProviders($provider);

        return !empty($registered);
    }

    /**
     * @inheritdoc
     */
    public function hasBooted($provider): bool
    {
        return in_array($provider, $this->booted());
    }

    /**
     * @inheritdoc
     */
    public function providers(): array
    {
        return $this->registered;
    }

    /**
     * @inheritDoc
     */
    public function getProviders($provider): array
    {
        // This function behaves the same way that Laravel's Application::getProviders
        // See https://github.com/laravel/framework/blob/6.x/src/Illuminate/Foundation/Application.php#L655
        $name = $this->providerNamespace($provider);

        return array_filter(
            $this->providers(),
            fn (ServiceProvider $registered) => $registered instanceof $name
        );
    }

    /**
     * @inheritdoc
     */
    public function booted(): array
    {
        return $this->booted;
    }

    /**
     * Create service provider instance, if required
     *
     * @param ServiceProvider|string $provider
     *
     * @return ServiceProvider
     */
    public function resolveProvider($provider)
    {
        if ($provider instanceof ServiceProvider) {
            return $provider;
        }

        return new $provider($this->getApp());
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Performs the registration of given service provider
     *
     * @param ServiceProvider $provider
     */
    protected function performRegistration(ServiceProvider $provider)
    {
        $provider->register();

        // Resolve "bindings" and "singletons" properties.
        // This is done in the exact same way as in Laravel's Application.
        // @see https://github.com/laravel/framework/blob/6.x/src/Illuminate/Foundation/Application.php#L596
        $ioc = $this->getApp();

        // Bindings
        if (property_exists($provider, 'bindings')) {
            foreach ($provider->bindings as $abstract => $concrete) {
                $ioc->bind($abstract, $concrete);
            }
        }

        // Singletons
        if (property_exists($provider, 'singletons')) {
            foreach ($provider->singletons as $abstract => $concrete) {
                $key = is_int($abstract)
                    ? $concrete
                    : $abstract;

                $ioc->singleton($key, $concrete);
            }
        }

        $this->markAsRegistered($provider);
    }

    /**
     * Mark service provider as registered
     *
     * @param ServiceProvider $provider
     *
     * @return void
     */
    protected function markAsRegistered(ServiceProvider $provider): void
    {
        $this->registered[] = $provider;
    }

    /**
     * Mark service provider as booted
     *
     * @param ServiceProvider $provider
     *
     * @return void
     */
    protected function markAsBooted(ServiceProvider $provider): void
    {
        $this->booted[] = $provider;
    }

    /**
     * Returns the given service provider's namespace
     *
     * @param ServiceProvider|string $provider
     *
     * @return string
     */
    protected function providerNamespace(ServiceProvider|string $provider): string
    {
        return is_string($provider)
            ? $provider
            : $provider::class;
    }
}
