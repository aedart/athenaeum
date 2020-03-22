<?php

namespace Aedart\Http\Clients\Requests\Builders\Concerns;

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
     * @inheritdoc
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
     * @inheritdoc
     */
    public function withAttachments(array $attachments = []): Builder
    {
        foreach ($attachments as $attachment) {
            $this->withAttachment($attachment);
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function withoutAttachment(string $name): Builder
    {
        unset($this->attachments[$name]);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function hasAttachment(string $name): bool
    {
        return isset($this->attachments[$name]);
    }

    /**
     * @inheritdoc
     */
    public function getAttachment(string $name): ?Attachment
    {
        if ($this->hasAttachment($name)) {
            return $this->attachments[$name];
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getAttachments(): array
    {
        return array_values($this->attachments);
    }

    /**
     * @inheritdoc
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
     * @inheritdoc
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
