<?php

namespace Aedart\Audit\Traits;

use Aedart\Audit\Concerns\AuditTrail;

/**
 * @deprecated Since 7.0, replaced by {@see \Aedart\Audit\Concerns\AuditTrail}
 *
 * Has Audit Trails
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Audit\Traits
 */
trait HasAuditTrail
{
    use AuditTrail;
}
