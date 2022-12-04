<?php

namespace Aedart\Http\Api\Requests\Resources;

use Aedart\Http\Api\Requests\Concerns;
use Aedart\Http\Api\Requests\ValidatedApiRequest;

/**
 * Show Single Resource Request
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Requests\Resources
 */
abstract class ShowSingleResourceRequest extends ValidatedApiRequest
{
    use Concerns\SingleRecord;

    /**
     * @inheritDoc
     */
    public function authorizeAfterValidation(): bool
    {
        return $this->allows('show', $this->record);
    }

    /**
     * @inheritDoc
     */
    protected function prepareForValidation()
    {
        // Attempt to find and prepare requested record, before
        // the validation is applied. This allows certain rules,
        // like `Rule::unique()->ignore()` to be applied safely.

        $this->findAndPrepareRecord();
    }
}