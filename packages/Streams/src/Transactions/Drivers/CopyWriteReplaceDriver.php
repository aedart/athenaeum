<?php

namespace Aedart\Streams\Transactions\Drivers;

use Aedart\Contracts\Streams\BufferSizes;
use Aedart\Contracts\Streams\FileStream as FileStreamInterface;
use Aedart\Contracts\Streams\Locks\Lock;
use Aedart\Contracts\Streams\Locks\Lockable;
use Aedart\Contracts\Streams\Locks\LockType;
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
     * Acquired lock
     *
     * @var Lock|null
     */
    protected Lock|null $lock = null;

    /**
     * @inheritDoc
     */
    public function canStartTransaction(Stream $stream): bool
    {
        return $stream->isOpen()
            && $stream->isReadable()
            && $stream->isWritable()
            && $stream instanceof FileStreamInterface;
    }

    /**
     * @inheritDoc
     */
    public function performBegin(Stream $originalStream): Stream
    {
        // First, lock the original stream so that other processes
        // do not interfere with its contents.
        if ($this->mustLock()) {
            $this->lock = $this->acquireLock(
                $originalStream,
                $this->lockProfile(),
                $this->lockType(),
                $this->lockTimeout()
            );
        }

        // Secondly, create a backup of the original stream and store
        // it inside a *.bak file.
        if ($this->mustBackup()) {
            $this->backupFile = $this->backupOriginalStream(
                $originalStream,
                $this->backupDirectory()
            );
        }

        // Third, create a new temporary stream which will be used as the
        // "processing stream" for the operation callback.
        $processingStream = $this->createProcessingStream();

        // Finally, copy the contents from the original stream into the
        // processing stream and return it.
        return $this->copyStream($originalStream, $processingStream);
    }

    /**
     * @inheritDoc
     */
    public function performCommit(Stream $processedStream, Stream $originalStream): void
    {
        /** @var FileStreamInterface $processedStream */
        /** @var FileStreamInterface $originalStream */

        // Both streams must be rewound, before we can continue...
        $processedStream->rewind();
        $originalStream->rewind();

        // The original stream's contents must be truncated. Afterwards, we will
        // copy the contents from the processing stream into the original.
        $this->copyStream(
            $processedStream,
            $originalStream->truncate(0)
        )->positionToEnd();

        // Automatically remove backup file, if any was made and requested...
        if ($this->mustRemoveBackupAfterCommit()) {
            $this->removeBackupFile($this->backupFile);
        }

        // Finally, if a lock was acquired then it must be released
        $this->releaseLock($this->lock);
    }

    /**
     * @inheritDoc
     */
    public function performRollback(Stream $processedStream, Stream $originalStream): void
    {
        /** @var FileStreamInterface $processedStream */
        /** @var FileStreamInterface $originalStream */

        // Since we do not know where in the process / operation a failure happened, we
        // truncate the processed stream and copy the original stream's contents back
        // into it.

        $originalStream->rewind();

        $this->copyStream(
            $originalStream,
            $processedStream->truncate(0)
        );

        // NOTE: We do NOT restore from evt. backup here. This could be a possibility,
        // yet the method knows nothing about how many attempts are left and thus when
        // to attempt restoring.
        // Overwrite "handleCommitFailure()" if you need more advanced rollback logic,
        // such as "restoring from backup"...
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * @inheritDoc
     *
     * @throws \Aedart\Contracts\Streams\Exceptions\LockException
     */
    protected function handleCommitFailure(Throwable $e, int $currentAttempt, int $maxAttempts)
    {
        try {
            parent::handleCommitFailure($e, $currentAttempt, $maxAttempts);
        } finally {
            // If maximum attempts have been reached and an exception was thrown,
            // then evt. acquired lock must be released.
            $this->releaseLock($this->lock);
        }
    }

    /**
     * Acquire lock for stream
     *
     * @param  Lockable|Stream  $stream
     * @param  string  $profile
     * @param  int|LockType  $type
     * @param  float  $timeout
     *
     * @return Lock
     *
     * @throws \Aedart\Contracts\Streams\Exceptions\LockException
     */
    protected function acquireLock(
        Lockable|Stream $stream,
        string $profile,
        int|LockType $type,
        float $timeout
    ): Lock {
        $lock = $stream
            ->getLockFactory()
            ->create($stream, $profile);

        $lock->acquire($type, $timeout);

        return $lock;
    }

    /**
     * Release lock
     *
     * @param  Lock|null  $lock
     *
     * @return bool
     *
     * @throws \Aedart\Contracts\Streams\Exceptions\LockException
     */
    protected function releaseLock(Lock|null $lock): bool
    {
        if (isset($lock) && !$lock->isReleased()) {
            $lock->release();

            return true;
        }

        return false;
    }

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
     * Creates a new processing stream instance
     *
     * @return FileStreamInterface
     *
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     */
    protected function createProcessingStream(): FileStreamInterface
    {
        return FileStream::openTemporary(
            'r+b',
            $this->maxMemory()
        );
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
        return $stream->restorePositionAfter(function (FileStreamInterface $stream) use ($target) {
            return $stream
                ->positionToStart()
                ->copyTo($target);
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
    protected function makeBackupFilename(FileStreamInterface $stream, string $directory): string
    {
        $uri = pathinfo($stream->uri(), PATHINFO_BASENAME);
        $date = Carbon::now()->format('Y_m_d_His_u');
        $filename = $uri . '_' . $date . '.bak';

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
    protected function ensureDirectoryExists(string $path): void
    {
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }
    }

    /**
     * Determine if original stream must be locked during transaction
     *
     * @return bool
     */
    protected function mustLock(): bool
    {
        return $this->get('lock.enabled', true);
    }

    /**
     * Returns the lock profile name
     *
     * @return string
     */
    protected function lockProfile(): string
    {
        return $this->get('lock.profile', 'default');
    }

    /**
     * Returns lock type to use
     *
     * @return int|LockType
     */
    protected function lockType(): int|LockType
    {
        return $this->get('lock.type', LockType::EXCLUSIVE);
    }

    /**
     * Returns acquire lock timeout
     *
     * @return float
     */
    protected function lockTimeout(): float
    {
        return $this->get('lock.timeout', 0.5);
    }

    /**
     * Returns maximum amount of memory for temporary stream,
     * before it is written to a physical file by PHP
     *
     * @return int Bytes
     */
    protected function maxMemory(): int
    {
        return $this->get('maxMemory', 5 * BufferSizes::BUFFER_1MB);
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
