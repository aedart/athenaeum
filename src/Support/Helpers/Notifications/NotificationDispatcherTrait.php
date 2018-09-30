<?php

namespace Aedart\Support\Helpers\Notifications;

use Illuminate\Contracts\Notifications\Dispatcher;
use Illuminate\Support\Facades\Notification;

/**
 * Notification Dispatcher Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Notifications\NotificationDispatcherAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Notifications
 */
trait NotificationDispatcherTrait
{
    /**
     * Notification Dispatcher instance
     *
     * @var Dispatcher|null
     */
    protected $notificationDispatcher = null;

    /**
     * Set notification dispatcher
     *
     * @param Dispatcher|null $dispatcher Notification Dispatcher instance
     *
     * @return self
     */
    public function setNotificationDispatcher(?Dispatcher $dispatcher)
    {
        $this->notificationDispatcher = $dispatcher;

        return $this;
    }

    /**
     * Get notification dispatcher
     *
     * If no notification dispatcher has been set, this method will
     * set and return a default notification dispatcher, if any such
     * value is available
     *
     * @see getDefaultNotificationDispatcher()
     *
     * @return Dispatcher|null notification dispatcher or null if none notification dispatcher has been set
     */
    public function getNotificationDispatcher(): ?Dispatcher
    {
        if (!$this->hasNotificationDispatcher()) {
            $this->setNotificationDispatcher($this->getDefaultNotificationDispatcher());
        }
        return $this->notificationDispatcher;
    }

    /**
     * Check if notification dispatcher has been set
     *
     * @return bool True if notification dispatcher has been set, false if not
     */
    public function hasNotificationDispatcher(): bool
    {
        return isset($this->notificationDispatcher);
    }

    /**
     * Get a default notification dispatcher value, if any is available
     *
     * @return Dispatcher|null A default notification dispatcher value or Null if no default value is available
     */
    public function getDefaultNotificationDispatcher(): ?Dispatcher
    {
        return Notification::getFacadeRoot();
    }
}
