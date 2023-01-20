<?php

namespace Aedart\Http\Api\Requests\Resources;

use Illuminate\Database\Eloquent\Model;

/**
 * Update Single Resource Request
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Requests\Resources
 */
abstract class UpdateSingleResourceRequest extends ShowSingleResourceRequest
{
    /**
     * @inheritDoc
     */
    public function authorizeFoundRecord(Model $record): bool
    {
        return $this->allows('update', $this->record);
    }
}
