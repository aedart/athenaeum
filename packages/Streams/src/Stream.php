<?php

namespace Aedart\Streams;

use Aedart\Contracts\Streams\Exceptions\LockException;
use Aedart\Contracts\Streams\Exceptions\StreamException;
use Aedart\Contracts\Streams\Locks\Factory;
use Aedart\Contracts\Streams\Locks\LockFactoryAware;
use Aedart\Contracts\Streams\Locks\LockTypes;
use Aedart\Contracts\Streams\Meta\Repository;
use Aedart\Contracts\Streams\Stream as StreamInterface;
use Aedart\Streams\Meta\Repository as DefaultMetaRepository;
use Aedart\Streams\Traits\LockFactoryTrait;
use Aedart\Support\Facades\IoCFacade;
use Psr\Http\Message\StreamInterface as PsrStreamInterface;

/**
 * Stream
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Streams
 */
abstract class Stream implements
    StreamInterface,
    LockFactoryAware
{
    use LockFactoryTrait;

    /**
     * @inheritDoc
     */
    public static function make($stream, array|Repository|null $meta = null): static
    {
        // TODO: Implement make() method.
    }

    /**
     * @inheritDoc
     */
    public static function makeFrom(PsrStreamInterface $stream, array|Repository|null $meta = null): static
    {
        // TODO: Implement makeFrom() method.
    }

    /**
     * @inheritDoc
     */
    public function detach()
    {
        // TODO: Implement detach() method.
    }

    /**
     * @inheritDoc
     */
    public function getSize(): int|null
    {
        // TODO: Implement getSize() method.
    }

    /**
     * @inheritDoc
     */
    public function tell(): int
    {
        // TODO: Implement tell() method.
    }

    /**
     * @inheritDoc
     */
    public function eof(): bool
    {
        // TODO: Implement eof() method.
    }

    /**
     * @inheritDoc
     */
    public function isSeekable(): bool
    {
        // TODO: Implement isSeekable() method.
    }

    /**
     * @inheritDoc
     */
    public function seek($offset, $whence = SEEK_SET)
    {
        // TODO: Implement seek() method.
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        // TODO: Implement rewind() method.
    }

    /**
     * @inheritDoc
     */
    public function isWritable(): bool
    {
        // TODO: Implement isWritable() method.
    }

    /**
     * @inheritDoc
     */
    public function write($string): int
    {
        // TODO: Implement write() method.
    }

    /**
     * @inheritDoc
     */
    public function isReadable(): bool
    {
        // TODO: Implement isReadable() method.
    }

    /**
     * @inheritDoc
     */
    public function read($length): string
    {
        // TODO: Implement read() method.
    }

    /**
     * @inheritDoc
     */
    public function getContents(): string
    {
        // TODO: Implement getContents() method.
    }

    /**
     * @inheritDoc
     */
    public function getMetadata($key = null)
    {
        // TODO: Implement getMetadata() method.
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        // TODO: Implement __toString() method.
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        return $this->getSize();
    }

    /**
     * @inheritDoc
     */
    public function readLine(?int $length = null): string|false
    {
        // TODO: Implement readLine() method.
    }

    /**
     * @inheritDoc
     */
    public function readLineUntil(int $length, string $ending = ''): string|false
    {
        // TODO: Implement readLineUntil() method.
    }

    /**
     * @inheritDoc
     */
    public function parse(string $format, mixed &...$vars): array|int|false|null
    {
        // TODO: Implement scanFormat() method.
    }

    /**
     * @inheritDoc
     */
    public function perform(callable $operation, bool $restorePosition = true): mixed
    {
        // TODO: Implement perform() method.
    }

    /**
     * @inheritDoc
     */
    public function performSafe(
        callable $operation,
        bool $restorePosition = true,
        int $lock = LockTypes::EXCLUSIVE,
        int $acquireLockTimeout = 500_000
    ): mixed {
        // TODO: Implement performSafe() method.
    }

    /**
     * @inheritDoc
     */
    public function position(): int
    {
        return $this->tell();
    }

    /**
     * @inheritDoc
     */
    public function passThrough(): int
    {
        // TODO: Implement passThrough() method.
    }

    /**
     * @inheritDoc
     */
    public function setBlocking(bool $block): static
    {
        // TODO: Implement setBlocking() method.
    }

    /**
     * @inheritDoc
     */
    public function setTimeout(int $seconds, int $microseconds = 0): static
    {
        // TODO: Implement setTimeout() method.
    }

    /**
     * @inheritDoc
     */
    public function resource()
    {
        // TODO: Implement resource() method.
    }

    /**
     * @inheritDoc
     */
    public function isDetached(): bool
    {
        // TODO: Implement isDetached() method.
    }

    /**
     * @inheritDoc
     */
    public function supportsLocking(): bool
    {
        // TODO: Implement supportsLocking() method.
    }

    /**
     * @inheritDoc
     */
    public function timedOut(): bool
    {
        // TODO: Implement timedOut() method.
    }

    /**
     * @inheritDoc
     */
    public function blocked(): bool
    {
        // TODO: Implement blocked() method.
    }

    /**
     * @inheritDoc
     */
    public function unreadBytes(): int
    {
        // TODO: Implement unreadBytes() method.
    }

    /**
     * @inheritDoc
     */
    public function streamType(): string
    {
        // TODO: Implement streamType() method.
    }

    /**
     * @inheritDoc
     */
    public function wrapperType(): string
    {
        // TODO: Implement wrapperType() method.
    }

    /**
     * @inheritDoc
     */
    public function wrapperData(): mixed
    {
        // TODO: Implement wrapperData() method.
    }

    /**
     * @inheritDoc
     */
    public function mode(): string
    {
        // TODO: Implement mode() method.
    }

    /**
     * @inheritDoc
     */
    public function uri(): string
    {
        // TODO: Implement uri() method.
    }

    /**
     * @inheritDoc
     */
    public function isLocal(): bool
    {
        // TODO: Implement isLocal() method.
    }

    /**
     * @inheritDoc
     */
    public function isTTY(): bool
    {
        // TODO: Implement isTTY() method.
    }

    /**
     * @inheritDoc
     */
    public function getFormattedSize(int $precision = 2): string
    {
        // TODO: Implement getFormattedSize() method.
    }

    /**
     * @inheritDoc
     */
    public function meta(): Repository
    {
        // TODO: Implement meta() method.
    }

    /**
     * @inheritDoc
     */
    public function rawMeta(): array
    {
        // TODO: Implement rawMeta() method.
    }

    /**
     * @inheritDoc
     */
    public function __debugInfo(): array
    {
        // TODO: Implement __debugInfo() method.
    }

    /*****************************************************************
     * Defaults
     ****************************************************************/

    /**
     * @inheritDoc
     */
    public function getDefaultLockFactory(): Factory|null
    {
        // TODO: Returns a default lock factory
    }

    /**
     * Returns a new meta repository instance
     *
     * @return Repository
     */
    public function makeMetaRepository(): Repository
    {
        return IoCFacade::tryMake(Repository::class, new DefaultMetaRepository());
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

}
