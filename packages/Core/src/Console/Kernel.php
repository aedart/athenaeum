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
use Symfony\Component\Console\Output\ConsoleOutput;
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
class Kernel implements ConsoleKernelInterface,
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
    protected ?Artisan $artisan = null;

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
    public function handle($input, $output = null)
    {
        return $this->attempt(function(ConsoleKernelInterface $kernel, $output) use($input){
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
        return $this
            ->setLastOutput($outputBuffer)
            ->runCore()
            ->getArtisan()
            ->call($command, $parameters, $outputBuffer);
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
        $this->runCore();

        foreach ($commands as $command){
            $this->addCommand($command);
        }
    }

    /**
     * @inheritDoc
     */
    public function addCommand($command)
    {
        $this->runCore();

        if(is_string($command)){
            $command = $this->getCoreApplication()->make($command);
        }

        $this->getArtisan()->add($command);
    }

    /**
     * @inheritDoc
     */
    public function setArtisan($artisan)
    {
        $this->artisan = $artisan;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getArtisan()
    {
        if( ! isset($this->artisan)){
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
        if($this->handleExceptionViaHandler($e, $output)){
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
     *
     * @param callable $callback Callback to be invoked
     * @param OutputInterface|null $output [optional] Defaults to Symfony's Console Output, if output not provided
     *
     * @return mixed
     */
    protected function attempt(callable $callback, OutputInterface $output = null)
    {
        $output = $output ?? new ConsoleOutput();
        $app = $this->getCoreApplication();

        // Force the application to throw exceptions, so that actual
        // handling is performed via this kernel.
        $mustThrow = $app->mustThrowExceptions();
        $app->forceThrowExceptions(true);

        try {
            // Attempt to perform whatever is being requested.
            $result = $callback($this, $output);
        } catch (Throwable $e) {

            $wasHandled = $this->handleException($e, $output);

            // In case exception was not handled via a handler, then
            // there is nothing we can do, other than rendering the
            // exception.
            if( ! $wasHandled){
                $this->getArtisan()->renderThrowable($e, $output);
            }

            return 1;
        }

        // Restore original "must throw" state
        $app->forceThrowExceptions($mustThrow);

        // Finally, return evt. output
        return $result;
    }

    /**
     * @param Throwable $e
     * @param OutputInterface $output
     *
     * @return bool
     */
    protected function handleExceptionViaHandler(Throwable $e, OutputInterface $output) : bool
    {
        $this->setLastOutput($output);

        /** @var Factory $factory */
        $factory = IoCFacade::tryMake(Factory::class);
        if( ! isset($factory)){
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
     * Bootstrap, boot and run the Core Application
     *
     * @return self
     *
     * @throws Throwable
     */
    protected function runCore()
    {
        $app = $this->getCoreApplication();
        if($app->isRunning()){
            return $this;
        }

        // Bootstrap, boot and run the core application
        $app->run();

        // Ensure that deferred services are registered immediately
        $app->loadDeferredProviders();

        return $this;
    }

    /**
     * Creates a new console application instance
     *
     * @return Artisan
     */
    protected function makeArtisan()
    {
        $console = new Artisan(
            $this->getCoreApplication(),
            $this->getDispatcher(),
            Version::package('aedart/athenaeum-console')
        );

        $console->setName(sprintf(
            'Athenaeum (via. Laravel Artisan ~ illuminate/console v.%s)',
            $this->laravelVersion()
        ));

        return $console;
    }

    /**
     * Returns the current installed Laravel Console package version
     *
     * @return string
     */
    protected function laravelVersion() : string
    {
        return Version::package('illuminate/console');
    }
}
