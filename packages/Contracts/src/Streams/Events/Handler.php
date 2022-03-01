<?php

namespace Aedart\Contracts\Streams\Events;

/**
 * Stream Event Handler
 *
 * @see \Aedart\Contracts\Streams\Events\StreamHasChanged
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Streams\Events
 */
interface Handler
{
    /**
     * Handles a stream has changed event
     *
     * @param  StreamHasChanged  $event
     *
     * @return void
     */
    public function handle(StreamHasChanged $event): void;
}
