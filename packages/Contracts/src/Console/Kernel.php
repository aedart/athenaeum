<?php

namespace Aedart\Contracts\Console;

use Aedart\Contracts\Console\Input\LastInputAware;
use Aedart\Contracts\Console\Output\LastOutputAware;
use Aedart\Contracts\Exceptions\UnsupportedOperationException;
use Illuminate\Contracts\Console\Kernel as LaravelConsoleKernel;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

/**
 * Console Kernel
 *
 * Adaptor between Laravel's Artisan Console application and
 * Athenaeum Core Application.
 *
 * @template C of \Symfony\Component\Console\Command\Command
 *
 * @see \Illuminate\Contracts\Console\Kernel
 * @see \Aedart\Contracts\Core\Application
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Console
 */
interface Kernel extends LaravelConsoleKernel,
    CoreApplicationAware,
    LastInputAware,
    LastOutputAware
{
    /*****************************************************************
     * Overwrites
     ****************************************************************/

    /**
     * NOT SUPPORTED in current adaptation of Kernel
     *
     * {@inheritDoc}
     *
     * @see https://github.com/laravel/ideas/issues/2036
     *
     * @throws UnsupportedOperationException
     */
    public function queue($command, array $parameters = []);

    /*****************************************************************
     * Custom Methods
     ****************************************************************/

    /**
     * Register a list of commands
     *
     * @see addCommand
     *
     * @param array<C|class-string<C>> $commands List of class paths or instances
     *
     * @return void
     */
    public function addCommands(array $commands);

    /**
     * Register a command
     *
     * @param C|class-string<C> $command Class path or instance
     *
     * @return void
     */
    public function addCommand($command);

    /**
     * Set Laravel's Artisan Console Application instance
     *
     * @param \Illuminate\Console\Application $artisan
     *
     * @return self
     */
    public function setArtisan($artisan): static;

    /**
     * Returns Laravel's Artisan Console Application instance
     *
     * @return \Illuminate\Console\Application|null
     */
    public function getArtisan();

    /**
     * Handles an exception
     *
     * Method will attempt to handle exception via application's
     * registered exception handler(s). If unable to handle, it defaults
     * to rendering the exception in the console.
     *
     * In case that the core application must throw exceptions, then this
     * must be respected by this method.
     *
     * @see \Aedart\Contracts\Core\Application::mustThrowExceptions
     *
     * @param Throwable $e
     * @param OutputInterface $output
     *
     * @throws Throwable In case that exceptions must be thrown
     *
     * @return void
     */
    public function handleException(Throwable $e, OutputInterface $output): void;
}
