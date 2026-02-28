<?php

namespace Aedart\Contracts\Http\Messages;

/**
 * Http Message Type
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Messages
 */
enum Type: string
{
    /**
     * Request type
     */
    case REQUEST = 'request';

    /**
     * Server Request type
     */
    case SERVER_REQUEST = 'server-request';

    /**
     * Response type
     */
    case RESPONSE = 'response';
}
