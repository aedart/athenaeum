<?php

namespace Aedart\Core\Bootstrappers;

use Aedart\Contracts\Core\Application;
use Aedart\Contracts\Core\Helpers\CanBeBootstrapped;
use Aedart\Core\Traits\ExceptionHandlerFactoryTrait;
use Aedart\Support\Helpers\Config\ConfigTrait;
use ErrorException;
use Throwable;

/**
 * Set Exception Handling
 *
 * Bootstrapper is responsible for setting error reporting,
 * error handling, exception handling and register a shutdown
 * function.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Core\Bootstrappers
 */
class SetExceptionHandling implements CanBeBootstrapped
{
    use ConfigTrait;
    use ExceptionHandlerFactoryTrait;

    /**
     * @inheritDoc
     */
    public function bootstrap(Application $application): void
    {
        // Skip this bootstrapper, if exception handling is disabled
        $config = $this->getConfig();
        if (!$config->get('exceptions.enabled', false)) {
            return;
        }

        // This upcoming part resembles that of Laravel's exception handling
        // defined within the foundation bootstrapper:
        // @see https://github.com/laravel/framework/blob/6.x/src/Illuminate/Foundation/Bootstrap/HandleExceptions.php

        // Set error reporting
        error_reporting($config->get('exceptions.error-reporting', -1));

        // Set error handler
        set_error_handler([$this, 'handleError']);

        // Set exception handler
        set_exception_handler([$this, 'handleException']);

        // Set shutdown handler
        register_shutdown_function([$this, 'handleShutdown'], $this->fatalErrors());

        // Set error displaying state
        $this->setErrorDisplay(
            $application->environment(),
            $config->get('exceptions.display-errors-in', [])
        );
    }

    /**
     * Handle PHP error by converting it to an exception
     *
     * @see https://www.php.net/manual/en/function.set-error-handler.php
     *
     * @param int $level Error severity
     * @param string $message Error message
     * @param string $file [optional] Filename where error occurred
     * @param int $line [optional] Line number in file
     *
     * @return bool False if error reporting is disabled or severity (level) is unknown
     *
     * @throws ErrorException
     */
    public function handleError(int $level, string $message, string $file = '', int $line = 0): bool
    {
        if (error_reporting() & $level) {
            throw new ErrorException($message, 0, $level, $file, $line);
        }

        return false;
    }

    /**
     * Handle exception
     *
     * @see https://www.php.net/manual/en/function.set-exception-handler.php
     *
     * @param Throwable $e
     *
     * @return bool True if handled, false if not
     *
     * @throws Throwable
     */
    public function handleException(Throwable $e): bool
    {
        $handler = $this->getExceptionHandlerFactory()->make();

        return $handler->handle($e);
    }

    /**
     * Handle shutdown
     *
     * If an error was detected during PHP shutdown, it will be passed on
     * to the registered exception handler, provided it's severity is
     * high enough.
     *
     * @see https://www.php.net/manual/en/function.register-shutdown-function.php
     * @see https://www.php.net/manual/en/function.error-get-last.php
     *
     * @param int[] $fatalErrors [optional] List of "fatal" error-severities
     *
     * @throws Throwable
     */
    public function handleShutdown(array $fatalErrors = []): void
    {
        $lastError = error_get_last();
        if (!isset($lastError)) {
            return;
        }

        $message = $lastError['message'] ?? 'unknown error during shutdown';
        $level = $lastError['type'] ?? E_ERROR;
        $file = $lastError['file'] ?? 'unknown';
        $line = $lastError['line'] ?? 0;

        if (in_array($level, $fatalErrors)) {
            $this->handleException(new ErrorException($message, 0, $level, $file, $line));
        }
    }

    /**
     * Sets the "display_error" directive
     *
     * If current environment is amongst given list of environments,
     * then error displaying will be enabled. Otherwise it will be
     * disabled.
     *
     * @param string $environment Current application environment
     * @param array $allowedInEnvironments [optional] List of allowed environments
     */
    public function setErrorDisplay(string $environment, array $allowedInEnvironments = []): void
    {
        // Enable if current environment is within the allowed environments
        if (in_array($environment, $allowedInEnvironments)) {
            ini_set('display_errors', '1');
            return;
        }

        // Disable otherwise
        ini_set('display_errors', '0');
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Returns list of "fatal" error-severities
     *
     * @see https://www.php.net/manual/en/errorfunc.constants.php
     *
     * @return int[]
     */
    protected function fatalErrors(): array
    {
        // In case that there is no list in the configuration, use this
        // default list of "fatal" errors, which match those used by
        // Laravel.
        // @see https://github.com/laravel/framework/blob/6.x/src/Illuminate/Foundation/Bootstrap/HandleExceptions.php#L158
        return $this->getConfig()->get('exceptions.fatal-errors', [
            E_COMPILE_ERROR,
            E_CORE_ERROR,
            E_ERROR,
            E_PARSE,
        ]);
    }
}
