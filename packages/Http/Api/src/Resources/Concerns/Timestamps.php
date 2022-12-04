<?php

namespace Aedart\Http\Api\Resources\Concerns;

use DateTimeInterface;

/**
 * Concerns Timestamps
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Resources\Concerns
 */
trait Timestamps
{
    /**
     * Datetime format to use
     *
     * @var string
     */
    protected string $datetimeFormat = DateTimeInterface::RFC3339;

    /**
     * Timestamps map
     *
     * NOTE: soft-delete timestamp is NOT part of this map.
     * see {@see getSoftDeleteTimestamps} for details.
     *
     * @var array Key = Eloquent model property name, value = payload key
     */
    protected array $timestampsMap = [
        'created_at' => 'created_at',
        'updated_at' => 'updated_at',
    ];

    /**
     * Add timestamps to given payload
     *
     * @param  array  $payload
     *
     * @return array
     */
    public function withTimestamps(array $payload = []): array
    {
        $resource = $this->resource;
        $timestamps = [];

        // Obtain resource's (eloquent model) timestamps and format them
        foreach ($this->timestampsMap as $eloquentKey => $payloadKey) {
            $timestamps[$payloadKey] = $this->formatDatetime($resource[$eloquentKey]);
        }

        // Obtain evt. soft delete timestamp, if available
        $softDeleteTimestamp = [];
        if ($this->supportsSoftDeletion($resource)) {
            $softDeleteTimestamp = $this->getSoftDeleteTimestamps($resource);
        }

        return array_merge($payload, $timestamps, $softDeleteTimestamp);
    }

    /**
     * Returns formatted "soft deleted" timestamp
     *
     * @param mixed $resource
     *
     * @return array
     */
    public function getSoftDeleteTimestamps(mixed $resource): array
    {
        return [
            'deleted' => !empty($resource->deleted_at),
            'deleted_at' => $this->formatDatetime($resource->deleted_at)
        ];
    }

    /**
     * Format given datetime
     *
     * @param  DateTimeInterface|null  $dateTime  [optional]
     * @param  string|null  $format  [optional] Defaults to {@see $datetimeFormat} when no format is given
     *
     * @return string|null Null when no datetime is given
     */
    public function formatDatetime(DateTimeInterface|null $dateTime = null, string|null $format = null): string|null
    {
        return $dateTime?->format($format ?? $this->datetimeFormat);
    }

    /**
     * Determine if resource supports soft deletions
     *
     * @param mixed $model
     *
     * @return bool
     */
    protected function supportsSoftDeletion(mixed $model): bool
    {
        return method_exists($model, 'trashed');
    }
}
