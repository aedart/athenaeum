<?php

namespace Aedart\Core\Exceptions\Handlers;

use Aedart\Contracts\Core\ApplicationAware;
use Aedart\Contracts\Exceptions\ExceptionHandler;
use Aedart\Contracts\Support\Helpers\Config\ConfigAware;
use Aedart\Contracts\Support\Helpers\Logging\LogAware;
use Aedart\Contracts\Support\Helpers\Logging\LogManagerAware;
use Aedart\Core\Traits\ApplicationTrait;
use Aedart\Support\Facades\IoCFacade;
use Aedart\Support\Helpers\Config\ConfigTrait;
use Aedart\Support\Helpers\Logging\LogManagerTrait;
use Aedart\Support\Helpers\Logging\LogTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Throwable;

/**
 * Base Exception Handler
 *
 * Abstract exception handler.
 *
 * @see \Aedart\Contracts\Exceptions\ExceptionHandler
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Core\Exceptions\Handlers
 */
abstract class BaseExceptionHandler implements
    ExceptionHandler,
    ApplicationAware,
    LogManagerAware,
    LogAware,
    ConfigAware
{
    use LogManagerTrait;
    use LogTrait;
    use ConfigTrait;
    use ApplicationTrait;

    /**
     * List of exception that should not be reported
     *
     * @var array<class-string<Throwable>> Class paths
     */
    protected array $dontReport = [];

    /**
     * @inheritDoc
     */
    public function shouldReport(Throwable $exception): bool
    {
        $dontReportList = $this->dontReport();
        foreach ($dontReportList as $exceptionNotToReport) {
            if ($exception instanceof $exceptionNotToReport) {
                return false;
            }
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function dontReport(): array
    {
        return $this->dontReport;
    }

    /**
     * @inheritDoc
     */
    public function report(Throwable $exception): void
    {
        if (!$this->shouldReport($exception)) {
            return;
        }

        // Perform actual reporting (logging in this case)
        $this->reportWithLevel($exception, LogLevel::ERROR);
    }

    /*****************************************************************
     * Defaults
     ****************************************************************/

    /**
     * @inheritdoc
     */
    public function getDefaultLog(): LoggerInterface|null
    {
        $channel = $this->getConfig()->get('exceptions.log-profile', 'stack');

        // Attempt resolve manager
        $manager = IoCFacade::tryMake('log');

        // Build log instance, if a manager was returned
        if (isset($manager) && method_exists($manager, 'channel')) {
            return $manager->channel($channel);
        }

        // Otherwise, we are not able to resolve the instance.
        return null;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Determine if the application is running in the console.
     *
     * @see \Illuminate\Contracts\Foundation\Application::runningInConsole
     *
     * @return bool
     */
    protected function runningInConsole(): bool
    {
        return $this->getApplication()->runningInConsole();
    }

    /**
     * Report given exception with the given severity
     *
     * @param Throwable $exception
     * @param string $level [optional] Psr-3 severity levels
     */
    protected function reportWithLevel(Throwable $exception, string $level = LogLevel::ERROR)
    {
        // Abort if no log instance is available.
        $logger = $this->getLog();
        if (!isset($logger)) {
            return;
        }

        // Try to build a context for given exception
        try {
            $context = $this->makeReportContext($exception);
        } catch (Throwable $e) {
            // For whatever reason we are not able to build a context
            // for the given exception. We log a message about this,
            // and build a default content.
            $logger->warning(
                'Unable to build exception context. Failure detected inside exception handler',
                [ 'exception' => $e ]
            );

            $context = [ 'exception-throw' => $exception::class ];
        }

        // Finally, log the exception with desired level
        $logger->log($level, $exception->getMessage(), $context);
    }

    /**
     * Builds a "context" for given exception which should be used
     * when reporting it.
     *
     * @param Throwable $exception
     *
     * @return array
     */
    protected function makeReportContext(Throwable $exception): array
    {
        return [
            'exception' => $exception
        ];
    }
}
