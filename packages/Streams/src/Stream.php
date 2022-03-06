<?php

namespace Aedart\Streams;

use Aedart\Contracts\Streams\Locks\Factory;
use Aedart\Contracts\Streams\Locks\LockFactoryAware;
use Aedart\Contracts\Streams\Locks\LockTypes;
use Aedart\Contracts\Streams\Meta\Repository;
use Aedart\Contracts\Streams\Stream as StreamInterface;
use Aedart\Streams\Exceptions\InvalidStreamResource;
use Aedart\Streams\Exceptions\StreamNotReadable;
use Aedart\Streams\Exceptions\StreamNotSeekable;
use Aedart\Streams\Exceptions\StreamException;
use Aedart\Streams\Exceptions\StreamIsDetached;
use Aedart\Streams\Exceptions\StreamNotWritable;
use Aedart\Streams\Meta\Repository as DefaultMetaRepository;
use Aedart\Streams\Traits\LockFactoryTrait;
use Aedart\Support\Facades\IoCFacade;
use Aedart\Utils\Memory;
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
     * Readable modes regex
     *
     * Source from Guzzle's Stream component
     *
     * @see \GuzzleHttp\Psr7\Stream::READABLE_MODES
     */
    public const READABLE_MODES = '/r|a\+|ab\+|w\+|wb\+|x\+|xb\+|c\+|cb\+/';

    /**
     * Writeable modes regex
     *
     * Source from Guzzle's Stream component
     *
     * @see \GuzzleHttp\Psr7\Stream::WRITABLE_MODES
     */
    public const WRITABLE_MODES = '/a|w|r\+|rb\+|rw|x|c/';

    /**
     * The actual resource stream
     *
     * @var resource
     */
    protected $stream;

    /**
     * Stream meta
     *
     * @var Repository
     */
    protected Repository $meta;

    /**
     * State whether stream is readable or not
     *
     * @var bool|null
     */
    protected bool|null $isReadable = null;

    /**
     * State whether stream is writable or not
     *
     * @var bool|null
     */
    protected bool|null $isWritable = null;

    /**
     * Creates a new stream instance
     *
     * @param resource $stream
     * @param  array|Repository|null  $meta  [optional]
     *
     * @throws InvalidStreamResource
     */
    public function __construct($stream, array|Repository|null $meta = null)
    {
        $this
            ->setStream($stream)
            ->setMetaRepository($meta);
    }

    /**
     * Stream destructor
     */
    public function __destruct()
    {
        $this->close();
    }

    /**
     * @inheritDoc
     */
    public static function make($stream, array|Repository|null $meta = null): static
    {
        return new static($stream, $meta);
    }

    /**
     * @inheritDoc
     */
    public static function makeFrom(PsrStreamInterface $stream, array|Repository|null $meta = null): static
    {
        return static::make($stream->detach(), $meta);
    }

    /**
     * @inheritDoc
     */
    public function detach()
    {
        if ($this->isDetached()) {
            return null;
        }

        $resource = $this->stream;
        unset(
            $this->stream,
            $this->meta,
            $this->isReadable,
            $this->isWritable
        );

        return $resource;
    }

    /**
     * @inheritDoc
     */
    public function getSize(): int|null
    {
        return $this->meta()->get('size');
    }

    /**
     * @inheritDoc
     */
    public function tell(): int
    {
        $this->assertNotDetached('Unable to tell stream position');

        $position = ftell($this->resource());

        if ($position === false) {
            throw new StreamException('Stream position cannot be determined');
        }

        return $position;
    }

    /**
     * @inheritDoc
     */
    public function eof(): bool
    {
        $this->assertNotDetached('Unable to determine if position is at end-of-file (EOF)');

        return feof($this->resource());
    }

    /**
     * @inheritDoc
     */
    public function isSeekable(): bool
    {
        return $this->meta()->get('seekable', false);
    }

    /**
     * @inheritDoc
     */
    public function seek($offset, $whence = SEEK_SET)
    {
        $msg = 'Unable to move stream position';

        $this->assertNotDetached($msg);
        if (!$this->isSeekable()) {
            throw new StreamNotSeekable('Stream is not seekable: ' . $msg);
        }

        $result = fseek($this->resource(), $offset, $whence);
        if ($result === -1) {
            throw new StreamException(sprintf('Stream position could not be moved to offset %s (whence %s)', $offset, $whence));
        }
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        $this->seek(0);
    }

    /**
     * @inheritDoc
     */
    public function isWritable(): bool
    {
        if (isset($this->isWritable)) {
            return $this->isWritable;
        }

        return $this->isWritable = (bool) preg_match(self::WRITABLE_MODES, $this->mode());
    }

    /**
     * @inheritDoc
     */
    public function write($string): int
    {
        $this
            ->assertNotDetached('Unable to write')
            ->assertIsWritable();

        $written = fwrite($this->resource(), $string);
        if ($written === false) {
            throw new StreamException(sprintf('Could not write %s byte to stream', strlen($string)));
        }

        return $written;
    }

    /**
     * @inheritDoc
     */
    public function isReadable(): bool
    {
        if (isset($this->isReadable)) {
            return $this->isReadable;
        }

        return $this->isReadable = (bool) preg_match(self::READABLE_MODES, $this->mode());
    }

    /**
     * @inheritDoc
     */
    public function read($length): string
    {
        $this
            ->assertNotDetached('Unable to read')
            ->assertIsReadable();

        $result = fread($this->resource(), $length);
        if ($result === false) {
            throw new StreamException(sprintf('Could not read %s bytes from stream', $length));
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function getContents(): string
    {
        $this
            ->assertNotDetached('Unable to get stream result')
            ->assertIsReadable();

        $result = stream_get_contents($this->resource());
        if ($result === false) {
            throw new StreamException('Could not obtain stream contents');
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function getMetadata($key = null)
    {
        return $this->meta()->get($key);
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        if ($this->isSeekable()) {
            $this->positionAtStart();
        }

        return $this->getContents();
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
        $this->assertNotDetached('Unable to read line');

        return fgets($this->resource(), $length);
    }

    /**
     * @inheritDoc
     */
    public function readLineUntil(int $length, string $ending = ''): string|false
    {
        $this->assertNotDetached('Unable to read line until ending');

        return stream_get_line($this->resource(), $length, $ending);
    }

    /**
     * @inheritDoc
     */
    public function parse(string $format, mixed &...$vars): array|int|false|null
    {
        $this->assertNotDetached('Unable to parse according to format ' . $format);

        return fscanf($this->resource(), $format, ...$vars);
    }

    /**
     * @inheritDoc
     */
    public function perform(callable $operation, bool $restorePosition = true): mixed
    {
        $original = $this->tell();

        $result = $operation($this);

        if ($restorePosition) {
            $this->seek($original);
        }

        return $result;
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
    public function positionAt(int $offset, int $whence = SEEK_SET): static
    {
        $this->seek($offset, $whence);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function positionAtStart(): static
    {
        return $this->positionAt(0);
    }

    /**
     * @inheritDoc
     */
    public function positionAtEnd(): static
    {
        return $this->positionAt(0, SEEK_END);
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
        $this->assertNotDetached('Unable output remaining data');

        return fpassthru($this->resource());
    }

    /**
     * @inheritDoc
     */
    public function setBlocking(bool $block): static
    {
        $this->assertNotDetached('Unable set blocking mode');

        $result = stream_set_blocking($this->resource(), $block);
        if ($result === false) {
            throw new StreamException(sprintf('Could not set stream blocking mode to %s', var_export($block, true)));
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setTimeout(int $seconds, int $microseconds = 0): static
    {
        $this->assertNotDetached('Unable set timeout');

        $result = stream_set_timeout($this->resource(), $seconds, $microseconds);
        if ($result === false) {
            throw new StreamException(sprintf('Could not set stream timeout to %d seconds and %d microseconds', $seconds, $microseconds));
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function resource()
    {
        return $this->stream;
    }

    /**
     * @inheritDoc
     */
    public function isDetached(): bool
    {
        return !isset($this->stream);
    }

    /**
     * @inheritDoc
     */
    public function supportsLocking(): bool
    {
        $this->assertNotDetached('Unable to determine locking support');

        return stream_supports_lock($this->resource());
    }

    /**
     * @inheritDoc
     */
    public function timedOut(): bool
    {
        return $this->meta()->get('timed_out', false);
    }

    /**
     * @inheritDoc
     */
    public function blocked(): bool
    {
        return $this->meta()->get('blocked', false);
    }

    /**
     * @inheritDoc
     */
    public function unreadBytes(): int
    {
        return $this->meta()->get('unread_bytes', 0);
    }

    /**
     * @inheritDoc
     */
    public function id(): int
    {
        $this->assertNotDetached('Unable to obtain resource id');

        return get_resource_id($this->resource());
    }

    /**
     * @inheritDoc
     */
    public function type(): string
    {
        $this->assertNotDetached('Unable to obtain resource type');

        return get_resource_type($this->resource());
    }

    /**
     * @inheritDoc
     */
    public function streamType(): string
    {
        return $this->meta()->get('stream_type', 'unknown');
    }

    /**
     * @inheritDoc
     */
    public function wrapperType(): string
    {
        return $this->meta()->get('wrapper_type', 'unknown');
    }

    /**
     * @inheritDoc
     */
    public function wrapperData(): mixed
    {
        return $this->meta()->get('wrapper_data');
    }

    /**
     * @inheritDoc
     */
    public function mode(): string
    {
        return $this->meta()->get('mode', 'unknown');
    }

    /**
     * @inheritDoc
     */
    public function uri(): string
    {
        return $this->meta()->get('uri', 'unknown');
    }

    /**
     * @inheritDoc
     */
    public function isLocal(): bool
    {
        $this->assertNotDetached('Unable to determine if stream is local');

        return stream_is_local($this->resource());
    }

    /**
     * @inheritDoc
     */
    public function isTTY(): bool
    {
        $this->assertNotDetached('Unable to determine if stream is a TTY');

        return stream_isatty($this->resource());
    }

    /**
     * @inheritDoc
     */
    public function getFormattedSize(int $precision = 2): string
    {
        $bytes = $this->getSize() ?? 0;

        return Memory::format($bytes, $precision);
    }

    /**
     * @inheritDoc
     */
    public function setMetaRepository(Repository|array|null $meta = null): static
    {
        $this->meta = $this->resolveMeta($meta);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function meta(): Repository
    {
        return $this
            ->meta
            ->merge($this->rawMeta());
    }

    /**
     * @inheritDoc
     */
    public function rawMeta(): array
    {
        if ($this->isDetached()) {
            return [];
        }

        return stream_get_meta_data($this->resource());
    }

    /**
     * @inheritDoc
     */
    public function __debugInfo(): array
    {
        $id = null;
        $type = null;
        $local = null;
        $isTTY = null;

        if (!$this->isDetached()) {
            $id = $this->id();
            $type = $this->type();
            $local = $this->isLocal();
            $isTTY = $this->isTTY();
        }

        return array_merge([
            'resource_id' => $id,
            'resource_type' => $type,
            'is_local' => $local,
            'isTTY' => $isTTY,
            'size_formatted' => $this->getFormattedSize()
        ], $this->meta()->all());
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

    /**
     * @param  mixed  $stream
     *
     * @return self
     */
    protected function setStream(mixed $stream): static
    {
        if (!is_resource($stream)) {
            throw new InvalidStreamResource('provided stream is not a resource');
        }

        $this->stream = $stream;

        return $this;
    }

    /**
     * Resolves provided meta
     *
     * @param  array|Repository|null  $meta  [optional]
     *
     * @return Repository
     */
    protected function resolveMeta(array|Repository|null $meta = null): Repository
    {
        if (is_array($meta)) {
            return $this->makeMetaRepository()
                ->merge($meta);
        }

        if ($meta instanceof Repository) {
            return $meta;
        }

        return $this->makeMetaRepository();
    }

    /**
     * Assert stream is not detached
     *
     * @param  string  $message  [optional]
     *
     * @return self
     *
     * @throws StreamIsDetached
     */
    protected function assertNotDetached(string $message = 'cannot perform operation'): static
    {
        if ($this->isDetached()) {
            throw new StreamIsDetached('Stream is detached: ' . $message);
        }

        return $this;
    }

    /**
     * Assert stream is writable
     *
     * @param  string  $message  [optional]
     *
     * @return self
     *
     * @throws StreamNotWritable
     */
    protected function assertIsWritable(string $message = 'cannot perform operation'): static
    {
        if (!$this->isWritable()) {
            throw new StreamNotWritable('Stream is not writable: ' . $message);
        }

        return $this;
    }

    /**
     * Assert stream is readable
     *
     * @param  string  $message  [optional]
     *
     * @return self
     *
     * @throws StreamNotWritable
     */
    protected function assertIsReadable(string $message = 'cannot perform operation'): static
    {
        if (!$this->isReadable()) {
            throw new StreamNotReadable('Stream is not readable: ' . $message);
        }

        return $this;
    }
}
