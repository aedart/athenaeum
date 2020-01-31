<?php


namespace Aedart\Testing\Athenaeum;

/**
 * Handles Application Callbacks
 *
 * Adapter to handle application callbacks during tests
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Testing\Laravel
 */
trait HandlesApplicationCallbacks
{
    /**
     * Callbacks to be invoked after the application has been created
     *
     * @var callable[]
     */
    protected array $afterAppCreated = [];

    /**
     * Callbacks to be invoked before the application is destroyed.
     *
     * @var callable[]
     */
    protected array $beforeAppDestroyed = [];

    /**
     * Register a callback to be invoked after application is created
     *
     * @param callable $callback
     */
    public function afterApplicationCreated(callable $callback)
    {
        $this->afterAppCreated[] = $callback;

        if($this->hasApplicationBeenStarted()){
            $callback();
        }
    }

    /**
     * Invoke the after created callbacks
     *
     * @see afterApplicationCreated
     */
    protected function invokeAfterCreatedCallbacks()
    {
        foreach ($this->afterAppCreated as $callback){
            $callback();
        }
    }

    /**
     * Register a callback to be invoked before the application is destroyed
     *
     * @param callable $callback
     */
    protected function beforeApplicationDestroyed(callable $callback)
    {
        $this->beforeAppDestroyed[] = $callback;
    }

    /**
     * Invoke the after created callbacks
     *
     * @see beforeApplicationDestroyed
     */
    protected function invokeBeforeDestroyedCallbacks()
    {
        foreach ($this->beforeAppDestroyed as $callback){
            $callback();
        }
    }
}
