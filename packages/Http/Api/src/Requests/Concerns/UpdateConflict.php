<?php

namespace Aedart\Http\Api\Requests\Concerns;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/**
 * @deprecated This needs to be reworked entirely!
 *
 * Concerns Update Conflict
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Requests\Concerns
 */
trait UpdateConflict
{
    /**
     * If true, then request will prevent update of
     * requested record if an "update conflict" is
     * detected.
     *
     * @var bool
     */
    protected bool $mustPreventUpdateConflict = true;

    /**
     * Eloquent model (record) attribute name that
     * holds the "last updated at" timestamp
     *
     * @var string
     */
    protected string $lastUpdatedAtKey = 'updated_at';

    public function abortRequestIfRecordAlreadyUpdated($record, Validator $validator): void
    {
        if ($this->hasRecordBeenUpdated($record, $this, $validator)) {
            // TODO: Fail...
        }
    }

    public function hasRecordBeenUpdated($record, Request $request, Validator $validator): bool
    {
        $recordLastUpdatedAt = $this->obtainRecordLastUpdatedAt($record);
        $submittedLastUpdatedAt = $this->obtainSubmittedLastUpdatedAt($request, $validator);

        if (empty($recordLastUpdatedAt) || empty($submittedLastUpdatedAt)) {
            return false;
        }

        return $recordLastUpdatedAt->notEqualTo($submittedLastUpdatedAt);
    }

    /**
     * Returns given record's "last updated at" timestamp
     *
     * @param \Illuminate\Database\Eloquent\Model $record
     *
     * @return Carbon|null Null if no timestamp was found on record
     */
    protected function obtainRecordLastUpdatedAt($record): Carbon|null
    {
        return Carbon::parse($record[$this->lastUpdatedAtKey]);
    }

    protected function obtainSubmittedLastUpdatedAt(Request $request, Validator $validator): Carbon|null
    {
    }

    // TODO: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/ETag
    // TODO: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Last-Modified
    // TODO: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/If-Unmodified-Since
}
