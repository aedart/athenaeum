<?php

namespace Aedart\Http\Api\Requests\Resources;

use Aedart\Contracts\ETags\Preconditions\ResourceContext;
use Illuminate\Database\Eloquent\Model;

/**
 * Delete Single Resource Request
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Requests\Resources
 */
abstract class DeleteSingleResourceRequest extends ShowSingleResourceRequest
{
    /**
     * @inheritDoc
     */
    public function authorizeFoundRecord(Model $record): bool
    {
        return $this->allows('destroy', $record);
    }

    /**
     * @inheritdoc
     */
    public function hasStateChangeAlreadySucceeded($request, ResourceContext $resource): bool
    {
        // In this case, if requested resource (model) is already deleted then the state
        // change has already succeeded.

        /** @var Model $model */
        $model = $resource->data();

        // @see \Illuminate\Database\Eloquent\SoftDeletes
        return method_exists($model, 'trashed') && $model->trashed();
    }
}
