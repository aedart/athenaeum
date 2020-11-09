<?php

namespace Aedart\Testing\Laravel;

use Closure;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Foundation\Application;
use Laravel\Dusk\Browser;
use LogicException;
use Orchestra\Testbench\Dusk\Bootstrap\LoadConfiguration;
use Orchestra\Testbench\Dusk\Concerns;
use Orchestra\Testbench\Dusk\Options as DuskOptions;

/**
 * Dusk Test Helper
 *
 * Integration to Laravel Dusk's Browser tests, using Orchestra's
 * "dusk" package.
 *
 * @see \Aedart\Testing\Laravel\LaravelTestHelper
 * @see https://github.com/orchestral/testbench-dusk
 * @see https://laravel.com/docs/8.x/dusk
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Testing\Laravel
 */
trait DuskTestHelper
{
    use LaravelTestHelper {
        startApplication as startLaravelApplication;
        stopApplication as stopLaravelApplication;
    }
    use Concerns\CanServeSite;
    use Concerns\ProvidesBrowser;

    /**
     * Protocol to use for browser tests
     *
     * @var string E.g. http, https
     */
    protected static string $serverProtocol = 'http';

    /**
     * Host url or ip address for browser tests
     *
     * @var string
     */
    protected static string $serverHost = '127.0.0.1';

    /**
     * Server port to use for browser tests
     *
     * @var int
     */
    protected static int $serverPort = 8000;

    /**
     * State whether or not shutdown function has been registered
     *
     * @var bool
     */
    protected static bool $hasRegisteredShutdown = false;

    /**
     * Locations where browser screenshots are stored
     *
     * @var string
     */
    protected string $browserScreenshots = 'tests/_output/browser/screenshots';

    /**
     * Locations where browser console logs are stored
     *
     * @var string
     */
    protected string $browserConsoleLogs = 'tests/_output/browser/console';

    /**
     * Location where a page's source code is stored
     *
     * @var string
     */
    protected string $browserSourceOutput = 'tests/_output/browser/source';

    /*****************************************************************
     * Setup Application & Browser
     ****************************************************************/

    /**
     * @inheritdoc
     */
    public function startApplication()
    {
        $this->startLaravelApplication();

        $this->setUpTheBrowserEnvironment();
        $this->registerShutdown();
    }

    /**
     * Returns application base path
     *
     * @return string
     */
    protected function getBasePath()
    {
        return __DIR__ . '/../laravel';
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Registers shutdown function, which ensures to close
     * all active browsers.
     */
    protected function registerShutdown(): void
    {
        if (static::$hasRegisteredShutdown) {
            return;
        }

        register_shutdown_function(function () {
            $this->closeAll();
        });

        static::$hasRegisteredShutdown = true;
    }

    /**
     * @inheritdoc
     */
    protected function resolveApplication()
    {
        return tap(new Application($this->getBasePath()), static function (Application  $app) {
            $app->bind(
                'Illuminate\Foundation\Bootstrap\LoadConfiguration',
                $this->resolveConfigurationLoaderBinding()
            );
        });
    }

    /**
     * Returns configuration loader 'bootstrapper' binding
     *
     * @return Closure|string|null
     */
    protected function resolveConfigurationLoaderBinding()
    {
        return LoadConfiguration::class;
    }

    /**
     * @inheritdoc
     */
    protected function driver(): RemoteWebDriver
    {
        return RemoteWebDriver::create(
            'http://localhost:9515',
            DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY,
                $this->makeChromeOptions()
            )
        );
    }

    /**
     * Creates options for Chrome browser
     *
     * @return mixed
     */
    protected function makeBrowserOptions()
    {
        return DuskOptions::getChromeOptions();
    }

    /**
     * @inheritdoc
     */
    protected function baseUrl()
    {
        return sprintf(
            '%s://%s:%d',
            static::serverProtocol(),
            static::serverHost(),
            static::serverPort()
        );
    }

    /**
     * Returns the server protocol
     *
     * @return string E.g. http, https
     */
    protected static function serverProtocol(): string
    {
        return static::$serverProtocol;
    }

    /**
     * Returns the server host
     *
     * @return string
     */
    protected static function serverHost(): string
    {
        return static::$serverHost;
    }

    /**
     * Returns the server port
     *
     * @return int
     */
    protected static function serverPort(): int
    {
        return static::$serverPort;
    }

    /**
     * @inheritdoc
     */
    protected function user()
    {
        throw new LogicException('No user resolver method specified. Unable to resolve user!');
    }

    /**
     * @inheritdoc
     */
    protected function prepareDirectories()
    {
        $this->prepareBrowserDirectories();

        Browser::$storeScreenshotsAt = $this->browserScreenshots;
        Browser::$storeConsoleLogAt = $this->browserConsoleLogs;
        Browser::$storeSourceAt = $this->browserSourceOutput;
    }

    /**
     * Prepares browser output directories
     */
    protected function prepareBrowserDirectories()
    {
        $directories = [
            $this->browserScreenshots,
            $this->browserConsoleLogs,
            $this->browserSourceOutput
        ];

        foreach ($directories as $dir) {
            if (!is_dir($dir)) {
                mkdir($dir, 0775, true);
            }
        }
    }
}
