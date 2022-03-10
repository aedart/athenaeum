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
        // Create a backup of the original stream, if required
        if ($this->mustBackup()) {
            $this->backupFile = $this->backupOriginalStream($originalStream,
                $this->backupDirectory()
            );
        }

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
        if ($this->mustRemoveBackupAfterCommit()) {
            $this->removeBackupFile($this->backupFile);
        }
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
     * Creates a backup of given stream
     *
     * @param  FileStreamInterface  $stream
     * @param string $directory Location where backup-file must be stored
     *
     * @return string Path to backup-file
     *
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    protected function backupOriginalStream(FileStreamInterface $stream, string $directory): string
    {
        // Create backup filename and ensure that directory is created, if it
        // does not already exist
        $backupFile = $this->makeBackupFilename($stream, $directory);
        $this->ensureDirectoryExists(
            pathinfo($backupFile, PATHINFO_DIRNAME)
        );

        // Copy and close the backup file stream
        $this->copyStream(
            $stream,
            FileStream::open($backupFile, 'w+b')
        )->close();

        return $backupFile;
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
     * @param  string  $directory
     *
     * @return string
     */
    protected function makeBackupFilename(FileStreamInterface $stream,  string $directory): string
    {
        $uri = pathinfo($stream->uri(), PATHINFO_BASENAME);
        $filename = $uri . '_' . Carbon::now()->timestamp . '.bak';

        return $directory . DIRECTORY_SEPARATOR . $filename;
    }

    /**
     * Remove given backup file
     *
     * @param  string|null  $backupFile Path to backup-file
     *
     * @return bool
     */
    protected function removeBackupFile(string|null $backupFile): bool
    {
        if (isset($backupFile) && is_file($backupFile)) {
            return unlink($backupFile);
        }

        return false;
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
        return $this->get('backup.enabled', false);
    }

    /**
     * Returns the backup directory location
     *
     * @return string
     */
    protected function backupDirectory(): string
    {
        return $this->get('backup.directory', getcwd() . DIRECTORY_SEPARATOR . 'backup');
    }

    /**
     * Determine if backup file must be removed after commit
     *
     * @return bool
     */
    public function mustRemoveBackupAfterCommit(): bool
    {
        return $this->mustBackup() && $this->get('backup.remove_after_commit', false);
    }
}
