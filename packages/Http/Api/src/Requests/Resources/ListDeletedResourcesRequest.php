<?php

namespace Aedart\Http\Api\Requests\Resources;

/**
 * List Deleted Resources Request
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Requests\Resources
 */
abstract class ListDeletedResourcesRequest extends ListResourcesRequest
{
    /**
     * @inheritdoc
     */
    public function authorize(): bool
    {
        return $this->allows('trashed', $this->authorisationModel());
    }
}
