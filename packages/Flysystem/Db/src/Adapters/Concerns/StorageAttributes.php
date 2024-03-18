<?php

namespace Aedart\Flysystem\Db\Adapters\Concerns;

use Aedart\Contracts\Flysystem\Db\RecordTypes;
use JsonException;
use League\Flysystem\DirectoryAttributes;
use League\Flysystem\FileAttributes;
use League\Flysystem\StorageAttributes as FlysystemStorageAttributes;
use LogicException;
use stdClass;

trait StorageAttributes
{
    /**
     * Normalise given record
     *
     * Method converts the given database record into a "file" or "directory"
     * attribute instance.
     *
     * @see RecordTypes::FILE
     * @see RecordTypes::DIRECTORY
     *
     * @param stdClass $record
     *
     * @return FlysystemStorageAttributes
     *
     * @throws LogicException If record "type" is missing or unknown
     * @throws JsonException If record's extra meta data cannot be decoded
     */
    protected function normaliseRecord(stdClass $record): FlysystemStorageAttributes
    {
        // Convert to array.
        $record = get_object_vars($record);

        return match ($record['type']) {
            RecordTypes::FILE->value => $this->makeFileAttribute($record),
            RecordTypes::DIRECTORY->value => $this->makeDirectoryAttribute($record),
            default => throw new LogicException(
                sprintf(
                    'Unable to normalise record of type %s. Allowed types: %s',
                    $record['type'],
                    implode(', ', RecordTypes::allowed())
                )
            )
        };
    }

    /**
     * Creates a new file attribute, for given file record
     *
     * @param array $record
     *
     * @return FlysystemStorageAttributes
     *
     * @throws JsonException
     */
    protected function makeFileAttribute(array $record): FlysystemStorageAttributes
    {
        $meta = $this->decodeExtraMetaData($record['extra_metadata']);
        $meta['level'] = $record['level'];
        $meta['hash'] = $record['content_hash'];

        return FileAttributes::fromArray([
            FlysystemStorageAttributes::ATTRIBUTE_PATH => $this->stripPrefix($record['path']),
            FlysystemStorageAttributes::ATTRIBUTE_FILE_SIZE => (int) $record['file_size'],
            FlysystemStorageAttributes::ATTRIBUTE_VISIBILITY => $record['visibility'],
            FlysystemStorageAttributes::ATTRIBUTE_LAST_MODIFIED => (int) $record['last_modified'],
            FlysystemStorageAttributes::ATTRIBUTE_MIME_TYPE => $record['mime_type'],
            FlysystemStorageAttributes::ATTRIBUTE_EXTRA_METADATA => $meta,
        ]);
    }

    /**
     * Creates a new directory attribute, for given directory record
     *
     * @param array $record
     *
     * @return FlysystemStorageAttributes
     *
     * @throws JsonException
     */
    protected function makeDirectoryAttribute(array $record): FlysystemStorageAttributes
    {
        $meta = $this->decodeExtraMetaData($record['extra_metadata']);
        $meta['level'] = $record['level'];

        return DirectoryAttributes::fromArray([
            FlysystemStorageAttributes::ATTRIBUTE_TYPE => $record['type'],
            FlysystemStorageAttributes::ATTRIBUTE_PATH => $this->stripPrefix($record['path']),
            FlysystemStorageAttributes::ATTRIBUTE_VISIBILITY => $record['visibility'],
            FlysystemStorageAttributes::ATTRIBUTE_LAST_MODIFIED => (int) $record['last_modified'],
            FlysystemStorageAttributes::ATTRIBUTE_EXTRA_METADATA => $meta,
        ]);
    }
}
