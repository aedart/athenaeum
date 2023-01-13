<?php

namespace Aedart\Http\Api\Requests\Resources;

use Aedart\Http\Api\Requests\ValidatedApiRequest;

/**
 * Create Single Resource Request
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Requests\Resources
 */
abstract class CreateSingleResourceRequest extends ValidatedApiRequest
{
    /**
     * @inheritdoc
     */
    public function authorize(): bool
    {
        return $this->allows('store', $this->authorisationModel());
    }
}
