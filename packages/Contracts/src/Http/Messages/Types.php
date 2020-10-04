<?php


namespace Aedart\Contracts\Http\Messages;

/**
 * Http Message Types
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Messages
 */
interface Types
{
    /**
     * Request type
     */
    public const TYPE_REQUEST = 'request';

    /**
     * Server Request type
     */
    public const TYPE_SERVER_REQUEST = 'server-request';

    /**
     * Response type
     */
    public const TYPE_RESPONSE = 'response';
}
