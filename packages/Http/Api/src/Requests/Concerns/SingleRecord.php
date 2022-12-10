<?php

namespace Aedart\Http\Api\Requests\Concerns;

use Aedart\Contracts\ETags\CanGenerateEtag;
use Aedart\Contracts\ETags\ETag;
use Aedart\Contracts\ETags\Exceptions\ETagGeneratorException;
use Aedart\Contracts\ETags\HasEtag;
use DateTimeInterface;
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

    /**
     * Returns record's etag (for strong comparison), if one is available
     *
     * @return ETag|null
     *
     * @throws ETagGeneratorException
     */
    public function getRecordStrongEtag(): ETag|null
    {
        $record = $this->record;

        return match (true) {
            $record instanceof HasEtag => $record->getStrongEtag(),
            $record instanceof CanGenerateEtag => $record->makeStrongEtag(),
            default => null
        };
    }

    /**
     * Returns record's etag (for weak comparison), if one is available
     *
     * @return ETag|null
     *
     * @throws ETagGeneratorException
     */
    public function getRecordWeakEtag(): ETag|null
    {
        $record = $this->record;

        return match (true) {
            $record instanceof HasEtag => $record->getWeakEtag(),
            $record instanceof CanGenerateEtag => $record->makeWeakEtag(),
            default => null
        };
    }

    /**
     * Returns record's last modified date, if a date is available
     *
     * @return DateTimeInterface|null
     */
    public function getRecordLastModifiedDate(): DateTimeInterface|null
    {
        $record = $this->record;

        $updatedAtColumn = $record->getUpdatedAtColumn();
        if (!isset($updatedAtColumn)) {
            return null;
        }

        return $record[$updatedAtColumn];
    }
}
