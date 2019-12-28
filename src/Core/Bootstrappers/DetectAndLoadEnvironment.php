<?php

namespace Aedart\Core\Bootstrappers;

use Aedart\Contracts\Core\Application;
use Aedart\Contracts\Core\Helpers\CanBeBootstrapped;
use Aedart\Core\Exceptions\UnableToDetectOrLoadEnv;
use Dotenv\Dotenv;
use Illuminate\Support\Env;
use Symfony\Component\Console\Input\ArgvInput;
use Throwable;

/**
 * Detect And Load Environment
 *
 * Responsible for detecting and loading environment variables.
 *
 * This bootstrapper is heavily inspired by Laravel's "LoadEnvironmentVariables" bootstrapper
 * @see https://github.com/laravel/framework/blob/6.x/src/Illuminate/Foundation/Bootstrap/LoadEnvironmentVariables.php#L12
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Core\Bootstrappers
 */
class DetectAndLoadEnvironment implements CanBeBootstrapped
{
    /**
     * Application instance
     *
     * @var Application
     */
    protected Application $app;

    /**
     * @inheritDoc
     */
    public function bootstrap(Application $application): void
    {
        $this->app = $application;

        try {
            $this->loadEnvironmentFile( $this->determineEnvFileToUse() );
        } catch (Throwable $e) {
            throw new UnableToDetectOrLoadEnv('Unable to detect or load environment: ' . $e->getMessage(), 1, $e);
        }
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Load the given environment file
     *
     * @param string $file
     */
    protected function loadEnvironmentFile(string $file)
    {
        // Set the environment file to be used by application
        $this->app->loadEnvironmentFrom($file);

        // Create Dot env instance
        $dotEnv = Dotenv::create(
            $this->app->environmentPath(),
            $this->app->environmentFile(),
            Env::getFactory()
        );

        // Finally, attempt to load environment
        $dotEnv->load();
    }

    /**
     * Determine the environment filename to use
     *
     * @return string
     */
    protected function determineEnvFileToUse() : string
    {
        // If an environment has already been specified, then we
        // must respect it. This can be done via the application's
        // "detectEnvironment" method, before bootstrapping!
        if(isset($this->app['env'])){
            return '.' . $this->app['env'];
        }

        // Attempt to read environment file from console
        $file = $this->getEnvFromConsole();
        if(isset($file)){
            return $this->loadEnvironmentFile($file);
        }

        // Otherwise, attempt to read file from environment directly.
        // Default to whatever the application has a default environment
        // file.
        return Env::get('APP_ENV', $this->app->environmentFile());
    }

    /**
     * Returns the environment filename from console, if able
     *
     * @return string|null Filename of environment file or null if unable to determine
     */
    protected function getEnvFromConsole() : ?string
    {
        if( ! $this->app->runningInConsole()){
            return null;
        }

        $input = new ArgvInput();
        if($input->hasParameterOption('--env')){
            return $input->getParameterOption('--env');
        }

        return null;
    }
}
