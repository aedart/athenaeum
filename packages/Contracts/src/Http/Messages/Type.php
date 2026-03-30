<?php

namespace Aedart\Contracts\Http\Messages;

use Aedart\Contracts\Utils\Enums\Concerns;
use JsonSerializable;

/**
 * Http Message Type
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Messages
 */
enum Type: string implements JsonSerializable
{
    use Concerns\BackedEnums;

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
