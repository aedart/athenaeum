<?php

namespace Aedart\Streams\Transactions\Drivers;

use Aedart\Contracts\Streams\BufferSizes;
use Aedart\Contracts\Streams\FileStream as FileStreamInterface;
use Aedart\Contracts\Streams\Stream;
use Aedart\Streams\FileStream;
use Illuminate\Support\Carbon;
use Throwable;

/**
 * Copy Write Replace Transaction Driver
 *
 * Driver will copy a file stream, process the copied stream and replace
 * the original stream's contents upon successful completion.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Streams\Transactions\Drivers
 */
class CopyWriteReplaceDriver extends BaseTransactionDriver
{
    /**
     * Path to backup-file
     *
     * @var string|null
     */
    protected string|null $backupFile = null;

    /**
     * @inheritDoc
     */
    public function canPerformTransaction(Stream $stream): bool
    {
        return $stream->isReadable()
            && $stream->isWritable()
            && $stream instanceof FileStreamInterface;
    }

    /**
     * @inheritDoc
     */
    public function performBegin(Stream $originalStream): Stream
    {
        $this->backupOriginalStream($originalStream);

        // Create a new temporary stream and copy original into it.
        // This will be the stream that the process method will operate on.

        $temp = FileStream::openTemporary(
            'r+b',
            $this->get('maxMemory', 5 * BufferSizes::BUFFER_1MB)
        );

        return $this->copyStream($originalStream, $temp);
    }

    /**
     * @inheritDoc
     */
    public function performCommit(Stream $processedStream, Stream $originalStream): void
    {
        /** @var FileStreamInterface $processedStream */
        /** @var FileStreamInterface $originalStream */

        $processedStream->rewind();
        $originalStream->rewind();

        // First the original stream's contents must be flushed. Afterwards, we will copy
        // the contents from the processed stream into the original.
        $this->copyStream(
            $processedStream,
            $originalStream->truncate(0)
        )->positionAtEnd();

        // Automatically remove backup file, if any was made and requested...
        $this->removeBackupFile();
    }

    /**
     * @inheritDoc
     */
    public function performRollback(Stream $processedStream, Stream $originalStream): void
    {
        /** @var FileStreamInterface $processedStream */
        /** @var FileStreamInterface $originalStream */

        // When a rollback is issues, we do not know where in the process the operation
        // or transaction failed. Furthermore, additional operation attempts might still
        // be available. Therefore, the processed stream needs to be truncated and a new
        // copy must be made.

        $originalStream->rewind();

        $this->copyStream(
            $originalStream,
            $processedStream->truncate(0)
        );

        // NOTE: We do NOT restore from evt. backup here. This could be a possibility,
        // yet the method knows nothing about amount of attempts left, etc.
        // Overwrite the "handleCommitFailure()", if even more advanced rollback
        // logic is required.
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Creates a backup of given stream, if required
     *
     * @param  FileStreamInterface  $stream
     *
     * @return self
     *
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    protected function backupOriginalStream(FileStreamInterface $stream)
    {
        // Skip if backup not required
        if (!$this->mustBackup()) {
            return $this;
        }

        // Create backup filename and ensure that directory is created, if it
        // does not already exist
        $this->backupFile = $this->makeBackupFilename($stream);
        $this->ensureDirectoryExists(
            pathinfo($this->backupFile, PATHINFO_DIRNAME)
        );

        // Copy and close the backup file stream
        $this->copyStream(
            $stream,
            FileStream::open($this->backupFile, 'w+b')
        )->close();

        return $this;
    }

    /**
     * Copy stream
     *
     * @param  FileStreamInterface  $stream The stream that must be copied
     * @param  FileStreamInterface  $target The stream to copy to
     *
     * @return FileStreamInterface Copied stream (target)
     *
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    protected function copyStream(FileStreamInterface $stream, FileStreamInterface $target): FileStreamInterface
    {
        return $stream->restorePositionAfter(function(FileStreamInterface $stream) use($target) {
            return $stream->copyTo($target);
        });
    }

    /**
     * Returns a filename of the backup file
     *
     * @param  FileStreamInterface  $stream
     *
     * @return string
     */
    protected function makeBackupFilename(FileStreamInterface $stream): string
    {
        $directory = $this->get('backup_directory', getcwd());
        $uri = pathinfo($stream->uri(), PATHINFO_BASENAME);
        $filename = $uri . '_' . Carbon::now()->timestamp . '.bak';

        return $directory . DIRECTORY_SEPARATOR . $filename;
    }

    /**
     * Removes backup file, if requested by settings and a backup
     * file was created.
     *
     * @see mustRemoveBackupAfterCommit()
     *
     * @return self
     */
    protected function removeBackupFile(): static
    {
        if ($this->mustRemoveBackupAfterCommit() && isset($this->backupFile)) {
            unlink($this->backupFile);
        }

        return $this;
    }

    /**
     * Creates directory, if it does not already exist
     *
     * @param  string  $path
     *
     * @return void
     */
    protected function ensureDirectoryExists(string $path)
    {
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }
    }

    /**
     * Determine if a backup must be made
     *
     * @return bool
     */
    protected function mustBackup(): bool
    {
        return $this->get('backup', false);
    }

    /**
     * Determine if backup file must be removed after commit
     *
     * @return bool
     */
    public function mustRemoveBackupAfterCommit(): bool
    {
        return $this->mustBackup() && $this->get('remove_backup_after_commit', false);
    }
}
