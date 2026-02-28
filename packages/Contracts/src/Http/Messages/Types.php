<?php


namespace Aedart\Contracts\Http\Messages;

/**
 * Http Message Types
 *
 * @deprecated Replaced by {@see \Aedart\Contracts\Http\Messages\Type}, since v10.x
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Messages
 */
interface Types
{
    /**
     * Request type
     *
     * @deprecated use {@see \Aedart\Contracts\Http\Messages\Type::REQUEST} instead, since v10.x
     */
    #[\Deprecated(message: "use \Aedart\Contracts\Http\Messages\Type::REQUEST instead", since: "10.x")]
    public const string TYPE_REQUEST = 'request';

    /**
     * Server Request type
     *
     * @deprecated use {@see \Aedart\Contracts\Http\Messages\Type::SERVER_REQUEST} instead, since v10.x
     */
    #[\Deprecated(message: "use \Aedart\Contracts\Http\Messages\Type::SERVER_REQUEST instead", since: "10.x")]
    public const string TYPE_SERVER_REQUEST = 'server-request';

    /**
     * Response type
     *
     * @deprecated use {@see \Aedart\Contracts\Http\Messages\Type::RESPONSE} instead, since v10.x
     */
    #[\Deprecated(message: "use \Aedart\Contracts\Http\Messages\Type::RESPONSE instead", since: "10.x")]
    public const string TYPE_RESPONSE = 'response';
}
