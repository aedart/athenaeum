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

        $this->whenRecordIsFound($this->record, $validator);
    }

    /**
     * Hook method for when requested record is found
     *
     * This method is invoked immediately after {@see findRecordOrFail},
     * if a record was found.
     *
     * @param \Illuminate\Database\Eloquent\Model $record
     * @param  Validator  $validator
     *
     * @return void
     */
    public function whenRecordIsFound($record, Validator $validator): void
    {
        // N/A - Overwrite this method if you need additional prepare or
        // validation logic, immediately after requested record was found.
    }
}