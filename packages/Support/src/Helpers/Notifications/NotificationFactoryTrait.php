<?php

namespace Aedart\Support\Helpers\Notifications;

use Illuminate\Contracts\Notifications\Factory;
use Illuminate\Support\Facades\Notification;

/**
 * Notification Factory Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Notifications\NotificationFactoryAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Notifications
 */
trait NotificationFactoryTrait
{
    /**
     * Notification Factory instance
     *
     * @var Factory|null
     */
    protected Factory|null $notificationFactory = null;

    /**
     * Set notification factory
     *
     * @param Factory|null $factory Notification Factory instance
     *
     * @return self
     */
    public function setNotificationFactory(Factory|null $factory): static
    {
        $this->notificationFactory = $factory;

        return $this;
    }

    /**
     * Get notification factory
     *
     * If no notification factory has been set, this method will
     * set and return a default notification factory, if any such
     * value is available
     *
     * @see getDefaultNotificationFactory()
     *
     * @return Factory|null notification factory or null if none notification factory has been set
     */
    public function getNotificationFactory(): Factory|null
    {
        if (!$this->hasNotificationFactory()) {
            $this->setNotificationFactory($this->getDefaultNotificationFactory());
        }
        return $this->notificationFactory;
    }

    /**
     * Check if notification factory has been set
     *
     * @return bool True if notification factory has been set, false if not
     */
    public function hasNotificationFactory(): bool
    {
        return isset($this->notificationFactory);
    }

    /**
     * Get a default notification factory value, if any is available
     *
     * @return Factory|null A default notification factory value or Null if no default value is available
     */
    public function getDefaultNotificationFactory(): Factory|null
    {
        return Notification::getFacadeRoot();
    }
}
