<?php

namespace Aedart\Console;

use Aedart\Console\Traits\CoreApplicationTrait;
use Aedart\Contracts\Console\Kernel as ConsoleKernelInterface;
use Aedart\Contracts\Core\Application;
use Aedart\Contracts\Exceptions\Factory;
use Aedart\Contracts\Support\Helpers\Events\DispatcherAware;
use Aedart\Support\Facades\IoCFacade;
use Aedart\Support\Helpers\Events\DispatcherTrait;
use Aedart\Utils\Version;
use Illuminate\Console\Application as Artisan;
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
        try {
            $this->runCore();

            return $this->getArtisan()->run($input, $output);
        } catch (Throwable $e) {

            $this->handleException($e, $output);

            return 1;
        }
    }

    /**
     * @inheritDoc
     */
    public function call($command, array $parameters = [], $outputBuffer = null)
    {
        return $this
            ->runCore()
            ->getArtisan()
            ->call($command, $parameters, $outputBuffer);
    }

    /**
     * @inheritDoc
     */
    public function queue($command, array $parameters = [])
    {
        // TODO: Implement queue() method.
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

    // TODO: UHm... assign input / output so exception handler(s) are able to
    // TODO: obtain them, if required.
    protected function handleExceptionViaHandler(Throwable $e, OutputInterface $output) : bool
    {
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
            'Athenaeum (via. Laravel ~ Illuminate/console v.%s)',
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
