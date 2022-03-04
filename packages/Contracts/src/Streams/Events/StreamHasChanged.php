<?php

namespace Aedart\Contracts\Streams\Events;

use Aedart\Contracts\Streams\Stream;

/**
 * Stream Has Changed Event
 *
 * Notification event is dispatched whenever changes occur on a stream.
 *
 * @see https://www.php.net/manual/en/function.stream-notification-callback.php
 * @see https://www.php.net/manual/en/stream.constants.php
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Streams\Events
 */
interface StreamHasChanged
{
    /**
     * Get the stream that was changed
     *
     * @return Stream
     */
    public function stream(): Stream;

    /**
     * Returns notification code. (STREAM_NOTIFY_*)
     *
     * @see https://www.php.net/manual/en/stream.constants.php
     *
     * @return int
     */
    public function code(): int;

    /**
     * Returns notification severity. (STREAM_NOTIFY_SEVERITY_*)
     *
     * @see https://www.php.net/manual/en/stream.constants.php
     *
     * @return int
     */
    public function severity(): int;

    /**
     * Determine if severity is of type "informational"
     *
     * @return bool True when severity is {@see STREAM_NOTIFY_SEVERITY_INFO}
     */
    public function isInformational(): bool;

    /**
     * Determine if severity is of type "warning"
     *
     * @return bool True when severity is {@see STREAM_NOTIFY_SEVERITY_WARN}
     */
    public function isWarning(): bool;

    /**
     * Determine if severity is of type "error"
     *
     * @return bool True when severity is {@see STREAM_NOTIFY_SEVERITY_ERR}
     */
    public function isError(): bool;
    
    /**
     * Returns a descriptive message if available.
     *
     * @see https://www.php.net/manual/en/function.stream-notification-callback.php
     *
     * @return string Empty if no message is available
     */
    public function message(): string;

    /**
     * Returns a descriptive message code if available.
     *
     * The meaning of the code depends on the specific wrapper used.
     *
     * @see https://www.php.net/manual/en/function.stream-notification-callback.php
     *
     * @return int
     */
    public function messageCode(): int;

    /**
     * Returns bytes transferred if available
     *
     * @see https://www.php.net/manual/en/function.stream-notification-callback.php
     *
     * @return int
     */
    public function bytesTransferred(): int;

    /**
     * Returns the max bytes (e.g. filesize), if available
     *
     * @see https://www.php.net/manual/en/function.stream-notification-callback.php
     *
     * @return int
     */
    public function maxBytes(): int;
}
