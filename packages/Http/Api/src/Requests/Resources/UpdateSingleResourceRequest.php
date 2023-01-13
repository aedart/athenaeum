<?php

namespace Aedart\Http\Api\Requests\Resources;

use Aedart\Http\Api\Requests\Concerns;

/**
 * Update Single Resource Request
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Requests\Resources
 */
abstract class UpdateSingleResourceRequest extends ShowSingleResourceRequest
{
    use Concerns\UpdateConflict;

    /**
     * @inheritDoc
     */
    public function authorizeAfterValidation(): bool
    {
        return $this->allows('update', $this->record);
    }

    /**
     * @inheritDoc
     */
    public function whenRecordIsFound($record): void
    {
        // TODO: Prevent update conflict, e.g. if ETags mismatch or If-Unmodified-Since header set...
    }
}
