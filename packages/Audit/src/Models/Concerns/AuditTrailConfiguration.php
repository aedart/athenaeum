<?php

namespace Aedart\Audit\Models\Concerns;

use Aedart\Audit\Concerns\AuditTrailConfig;

/**
 * @deprecated Since 7.0, replaced by {@see \Aedart\Audit\Concerns\AuditTrailConfig}
 *
 * Concerns Audit Trail Configuration
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Audit\Models\Concerns
 */
trait AuditTrailConfiguration
{
    use AuditTrailConfig;
}
