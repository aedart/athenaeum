<?php

namespace Aedart\Http\Clients\Requests\Builders\Concerns;

use Aedart\Contracts\Http\Clients\Exceptions\InvalidAttachmentFormatException;
use Aedart\Contracts\Http\Clients\Exceptions\InvalidFilePathException;
use Aedart\Contracts\Http\Clients\Requests\Attachment;
use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Http\Clients\Exceptions\InvalidAttachmentFormat;
use Aedart\Http\Clients\Requests\Attachment as RequestAttachment;

/**
 * Concerns Attachments
 *
 * @see Builder
 * @see Builder::withAttachment
 * @see Builder::withAttachments
 * @see Builder::withoutAttachment
 * @see Builder::hasAttachment
 * @see Builder::getAttachment
 * @see Builder::getAttachments
 * @see Builder::attachFile
 * @see Builder::makeAttachment
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Concerns
 */
trait Attachments
{
    /**
     * Attachments
     *
     * @var Attachment[] Key = form input name, value = attachment instance
     */
    protected array $attachments = [];

    /**
     * Add an attachment to the next request
     *
     * @param Attachment|array|callable $attachment If a callback is provided, a new {@see Attachment}
     *                          instance will be given as the callback's argument.
     *
     * @return self
     *
     * @throws InvalidAttachmentFormatException
     */
    public function withAttachment($attachment): Builder
    {
        $this->multipartFormat();

        if (is_array($attachment)) {
            $attachment = $this->makeAttachment($attachment);
        }

        if (is_callable($attachment)) {
            $attachment = $this->resolveCallbackAttachment($attachment);
        }

        if (!($attachment instanceof Attachment)) {
            throw new InvalidAttachmentFormat('Argument must be an Attachment instance, array, or callback');
        }

        // Add to list of attachments
        $this->attachments[$attachment->getName()] = $attachment;

        return $this;
    }

    /**
     * Add one or more attachments to the next request
     *
     * @see withAttachment
     *
     * @param Attachment[]|callable[] $attachments List of attachments, callbacks or data-arrays
     *                              Callbacks are given new {@see Attachment} instance as argument.
     *
     * @return self
     *
     * @throws InvalidAttachmentFormatException
     */
    public function withAttachments(array $attachments = []): Builder
    {
        foreach ($attachments as $attachment) {
            $this->withAttachment($attachment);
        }

        return $this;
    }

    /**
     * Remove an attachment from the next request
     *
     * @param string $name Form input name
     *
     * @return self
     */
    public function withoutAttachment(string $name): Builder
    {
        unset($this->attachments[$name]);

        return $this;
    }

    /**
     * Determine if an attachment exists
     *
     * @param string $name Form input name
     *
     * @return bool
     */
    public function hasAttachment(string $name): bool
    {
        return isset($this->attachments[$name]);
    }

    /**
     * Get the attachment with the given name
     *
     * @param string $name Form input name
     *
     * @return Attachment|null
     */
    public function getAttachment(string $name): ?Attachment
    {
        if ($this->hasAttachment($name)) {
            return $this->attachments[$name];
        }

        return null;
    }

    /**
     * Get the attachments for the next request
     *
     * @return Attachment[]
     */
    public function getAttachments(): array
    {
        return array_values($this->attachments);
    }

    /**
     * Attach a file to the next request
     *
     * @see withAttachment
     *
     * @param string $name Form input name
     * @param string $path Path to file
     * @param array $headers [optional] Http headers for attachment
     * @param string|null $filename [optional] Filename to be used by request
     *
     * @return self
     *
     * @throws InvalidFilePathException If path to file is invalid
     * @throws InvalidAttachmentFormatException
     */
    public function attachFile(
        string $name,
        string $path,
        array $headers = [],
        ?string $filename = null
    ): Builder {
        $attachment = $this->makeAttachment([
            'name' => $name,
            'headers' => $headers,
            'filename' => $filename
        ])->attachFile($path);

        return $this->withAttachment($attachment);
    }

    /**
     * Creates a new attachment instance.
     *
     * Method does NOT add the attachment into builder's
     * list of attachments.
     *
     * @param array $data [optional]
     *
     * @return Attachment
     */
    public function makeAttachment(array $data = []): Attachment
    {
        return new RequestAttachment($data);
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Resolves an attachment from given callback
     *
     * @param callable $callback New {@see Attachment} instance is given as callback argument
     *
     * @return Attachment
     */
    protected function resolveCallbackAttachment(callable $callback): Attachment
    {
        // Create attachment
        $attachment = $this->makeAttachment();

        // Invoke callback
        $callback($attachment);

        // Finally, return attachment
        return $attachment;
    }
}
