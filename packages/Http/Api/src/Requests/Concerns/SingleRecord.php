<?php

namespace Aedart\Http\Api\Requests\Concerns;

use Illuminate\Contracts\Validation\Validator;

/**
 * Concerns a Single Record
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Requests\Concerns
 */
trait SingleRecord
{
    /**
     * The requested record
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $record;

    /**
     * Find the requested record or fail
     *
     * @param  Validator  $validator
     *
     * @return \Illuminate\Database\Eloquent\Model
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    abstract public function findRecordOrFail(Validator $validator);

    /**
     * Prepare the requested record
     *
     * @param  Validator  $validator
     *
     * @return void
     */
    public function prepareRecord(Validator $validator): void
    {
        $this->record = $this->findRecordOrFail($validator);
    }
}