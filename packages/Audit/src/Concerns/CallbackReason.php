<?php

namespace Aedart\Audit\Concerns;

use Aedart\Contracts\Audit\CallbackReason as CallbackReasonInterface;
use Aedart\Support\Facades\IoCFacade;

/**
 * Concerns Callback Reason
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Audit\Concerns
 */
trait CallbackReason
{
    /**
     * Returns audit trail entry callback reason
     *
     * @return CallbackReasonInterface
     */
    public function callbackReason(): CallbackReasonInterface
    {
        return IoCFacade::make(CallbackReasonInterface::class);
    }
}
