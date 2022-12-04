<?php

namespace Aedart\Http\Api\Requests\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
     * @var Model
     */
    public Model $record;

    /**
     * Finds the requested record or fail
     *
     * @return Model
     *
     * @throws ModelNotFoundException
     */
    abstract public function findRecordOrFail(): Model;

    /**
     * Finds and prepares the requested record
     *
     * @return void
     */
    public function findAndPrepareRecord(): void
    {
        $this->record = $this->findRecordOrFail();

        $this->whenRecordIsFound($this->record);
    }

    /**
     * Hook method for when requested record is found
     *
     * This method is invoked immediately after {@see findRecordOrFail},
     * if a record was found.
     *
     * @param Model $record
     *
     * @return void
     */
    public function whenRecordIsFound(Model $record): void
    {
        // N/A - Overwrite this method if you need additional prepare or
        // validation logic, immediately after requested record was found.
    }
}
