<?php

namespace Aedart\Http\Messages\Serializers;

use Aedart\Contracts\Http\Messages\Serializer;
use Aedart\Http\Messages\Traits\HttpMessageTrait;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\StreamInterface;
use RuntimeException;

/**
 * Base Serializer
 *
 * Http Message abstraction.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Messages\Serializers
 */
abstract class BaseSerializer implements Serializer
{
    use HttpMessageTrait;

    /**
     * BaseSerializer constructor.
     *
     * @param  MessageInterface|null  $message  [optional]
     */
    public function __construct(?MessageInterface $message = null)
    {
        $this->setHttpMessage($message);
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Serialize Http Headers to a string
     *
     * @param  array  $headers  [optional]
     *
     * @return string
     */
    protected function serialiseHeaders(array $headers = []): string
    {
        // Inspired by Laminas "Abstract Serialiser"
        // @see https://github.com/laminas/laminas-diactoros/blob/2.5.x/src/AbstractSerializer.php#L128

        $output = [];

        foreach ($headers as $header => $values) {
            $name = $this->normaliseHeaderName($header);
            foreach ($values as $value) {
                $output[] = sprintf('%s: %s', $name, $value);
            }
        }

        return implode(PHP_EOL, $output);
    }

    /**
     * Normalises the Http Header name
     *
     * @param string $name
     *
     * @return string
     */
    protected function normaliseHeaderName(string $name): string
    {
        $filtered = ucwords(str_replace('-', ' ', $name));
        return str_replace(' ', '-', $filtered);
    }

    /**
     * Safely extracts the message's content and returns it
     *
     * @param  MessageInterface  $message
     *
     * @return string
     *
     * @throws RuntimeException If unable to read stream
     */
    protected function messageContent(MessageInterface $message): string
    {
        $stream = $message->getBody();

        // Rewind before obtaining content
        $isSeekable = $stream->isSeekable();
        if ($isSeekable) {
            $stream->rewind();
        }

        // Read content, fail otherwise.
        $content = $stream->getContents();

        // Rewind again, if seekable...
        if ($isSeekable) {
            $stream->rewind();
        }

        return $content;
    }

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        return $this->toString();
    }
}
