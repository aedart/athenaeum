<?php

namespace Aedart\Core\Console;

use Aedart\Console\Traits\CoreApplicationTrait;
use Aedart\Console\Traits\LastInputTrait;
use Aedart\Console\Traits\LastOutputTrait;
use Aedart\Contracts\Console\Kernel as ConsoleKernelInterface;
use Aedart\Contracts\Core\Application;
use Aedart\Contracts\Exceptions\Factory;
use Aedart\Contracts\Support\Helpers\Events\DispatcherAware;
use Aedart\Support\Facades\IoCFacade;
use Aedart\Support\Helpers\Events\DispatcherTrait;
use Aedart\Utils\Exceptions\UnsupportedOperation;
use Aedart\Utils\Version;
use Illuminate\Console\Application as Artisan;
use Illuminate\Console\OutputStyle;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

/**
 * Console Kernel
 *
 * Adaptor between Laravel's Artisan Console application and
 * Athenaeum Core Application.
 *
 * @see \Aedart\Contracts\Console\Kernel
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Console
 */
class Kernel implements
    ConsoleKernelInterface,
    DispatcherAware
{
    use CoreApplicationTrait;
    use LastInputTrait;
    use LastOutputTrait;
    use DispatcherTrait;

    /**
     * Laravel's Artisan Console Application instance
     *
     * @var Artisan|null
     */
    protected Artisan|null $artisan = null;

    /**
     * Console Kernel constructor.
     *
     * @param Application $core
     */
    public function __construct(Application $core)
    {
        $this->setCoreApplication($core);
    }

    /**
     * @inheritDoc
     */
    public function bootstrap()
    {
        $app = $this->getCoreApplication();
        if ($app->isRunning()) {
            return $this;
        }

        // Bootstrap, boot and run the core application
        $app->run();

        // Ensure that deferred services are registered immediately
        $app->loadDeferredProviders();
    }

    /**
     * @inheritDoc
     */
    public function handle($input, $output = null)
    {
        return $this->attempt(function (ConsoleKernelInterface $kernel, $output) use ($input) {
            return $this
                ->setLastInput($input)
                ->setLastOutput($output)
                ->runCore()
                ->getArtisan()
                ->run($input, $output);
        }, $output);
    }

    /**
     * @inheritDoc
     */
    public function call($command, array $parameters = [], $outputBuffer = null)
    {
        return $this->attempt(function (ConsoleKernelInterface $kernel, $output) use ($command, $parameters) {
            return $this
                ->setLastOutput($output)
                ->runCore()
                ->getArtisan()
                ->call($command, $parameters, $output);
        }, $outputBuffer);
    }

    /**
     * @inheritDoc
     */
    public function queue($command, array $parameters = [])
    {
        $msg = 'queue() method is not supported in this adapted version of Console Kernel.';
        $msg .= ' See https://github.com/laravel/ideas/issues/2036 for more information.';

        throw new UnsupportedOperation($msg);
    }

    /**
     * @inheritDoc
     */
    public function all()
    {
        return $this
            ->runCore()
            ->getArtisan()
            ->all();
    }

    /**
     * @inheritDoc
     */
    public function output()
    {
        return $this
            ->runCore()
            ->getArtisan()
            ->output();
    }

    /**
     * @inheritDoc
     */
    public function terminate($input, $status)
    {
        $this->getCoreApplication()->terminate();
    }

    /*****************************************************************
     * Custom methods implementation
     ****************************************************************/

    /**
     * @inheritDoc
     */
    public function addCommands(array $commands)
    {
        foreach ($commands as $command) {
            $this->addCommand($command);
        }
    }

    /**
     * @inheritDoc
     */
    public function addCommand($command)
    {
        $this->runCore();

        if (is_string($command)) {
            $command = $this->getCoreApplication()->make($command);
        }

        $this->getArtisan()->add($command);
    }

    /**
     * @inheritDoc
     */
    public function setArtisan($artisan): static
    {
        $this->artisan = $artisan;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getArtisan()
    {
        if (!isset($this->artisan)) {
            $this->setArtisan($this->makeArtisan());
        }

        return $this->artisan;
    }

    /**
     * @inheritDoc
     */
    public function handleException(Throwable $e, OutputInterface $output): void
    {
        // Attempt to handle exception via registered exception handler(s)
        if ($this->handleExceptionViaHandler($e, $output)) {
            return;
        }

        // Otherwise, we simply render the exception...
        $this->getArtisan()->renderThrowable($e, $output);
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Attempt to perform some action.
     *
     * If given callback should fail (throw exception), then method will
     * delegate the exception to assigned exception handler.
     *
     * @see handleException
     * @see \Aedart\Contracts\Core\Application::mustThrowExceptions
     *
     * @param callable $callback Callback to be invoked
     * @param OutputInterface|null $output [optional] Defaults to Symfony's Console Output, if output not provided
     *
     * @return mixed
     *
     * @throws Throwable In case exceptions must be thrown
     */
    protected function attempt(callable $callback, OutputInterface $output = null): mixed
    {
        $output = $output ?? $this->resolveDefaultOutput();

        try {
            // Attempt to perform whatever is being requested.
            $result = $callback($this, $output);
        } catch (Throwable $e) {
            // Force throw exceptions if required by application
            if ($this->getCoreApplication()->mustThrowExceptions()) {
                throw $e;
            }

            $this->handleException($e, $output);

            return 1;
        }

        // Finally, return evt. output
        return $result;
    }

    /**
     * Handle given exception via registered exception handler
     *
     * @param Throwable $e
     * @param OutputInterface $output
     *
     * @return bool
     */
    protected function handleExceptionViaHandler(Throwable $e, OutputInterface $output): bool
    {
        $this->setLastOutput($output);

        /** @var Factory $factory */
        $factory = IoCFacade::tryMake(Factory::class);
        if (!isset($factory)) {
            return false;
        }

        try {
            $handler = $factory->make();

            return $handler->handle($e);
        } catch (Throwable $handlerException) {
            // In case exception was (re)thrown via handler, we simply output
            // it here... nothing else was can
            $this->getArtisan()->renderThrowable($handlerException, $output);

            return true;
        }
    }

    /**
     * Resolves a default output instance
     *
     * @return OutputInterface
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function resolveDefaultOutput(): OutputInterface
    {
        $core = $this->getCoreApplication();

        // Laravel's Console binds OutputStyle inside their commands...
        if ($core->bound(OutputStyle::class)) {
            return $core->make(OutputStyle::class);
        }

        return new BufferedOutput();
    }

    /**
     * Bootstrap, boot and run the Core Application
     *
     * @return self
     *
     * @throws Throwable
     */
    protected function runCore(): static
    {
        $this->bootstrap();

        return $this;
    }

    /**
     * Creates a new console application instance
     *
     * @return Artisan
     */
    protected function makeArtisan(): Artisan
    {
        $console = new Artisan(
            $this->getCoreApplication(),
            $this->getDispatcher(),
            Version::package('aedart/athenaeum-console')
        );

        $console->setContainerCommandLoader();

        $console->setName(sprintf(
            '<fg=blue>Athenaeum</> (via. Laravel Artisan ~ <comment>illuminate/console</comment> %s)',
            $this->laravelVersion()
        ));

        return $console;
    }

    /**
     * Returns the current installed Laravel Console package version
     *
     * @return string
     */
    protected function laravelVersion(): string
    {
        if (Version::hasFor('illuminate/console')) {
            return Version::package('illuminate/console');
        }

        // NOTE: This should NOT be the case, because the core
        // application is not able to be used inside a normal
        // Laravel project. However, during test while using
        // orchestra test-bench, the entire framework is installed,
        // replacing illuminate/console and causes the previous
        // condition to fail. Thus, attempt to determine if this
        // is the case and return laravel's installed version.

        if (Version::hasFor('laravel/framework')) {
            return Version::package('laravel/framework');
        }

        return 'unknown';
    }
}
