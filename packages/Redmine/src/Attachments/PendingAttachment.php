<?php

namespace Aedart\Redmine\Attachments;

use Aedart\Redmine\Attachment;
use Illuminate\Contracts\Support\Arrayable;
use InvalidArgumentException;

/**
 * Pending Attachment
 *
 * An attachment that was recently uploaded (has a token) and about to
 * be associated with a resource
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Redmine\Attachments
 */
class PendingAttachment implements Arrayable
{
    /**
     * The actual attachment to be associated with
     * a resource.
     *
     * @var Attachment
     */
    public Attachment $attachment;

    /**
     * PendingAttachment
     *
     * @param Attachment $attachment
     *
     * @throws InvalidArgumentException If attachment does not have a token or id
     */
    public function __construct(Attachment $attachment)
    {
        if (!($attachment->hasToken() && $attachment->exists())) {
            throw new InvalidArgumentException(sprintf('Attachment %s must have a token and id before it can be associated with resource', $attachment->filename));
        }

        $this->attachment = $attachment;
    }

    /**
     * Create a new pending attachment
     *
     * @param Attachment $attachment
     *
     * @return static
     *
     * @throws InvalidArgumentException If attachment does not have a token or id
     */
    public static function make(Attachment $attachment): static
    {
        return new static($attachment);
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'token' => $this->attachment->token,
            'filename' => $this->attachment->filename,
            'content_type' => $this->attachment->content_type,
            'description' => $this->attachment->description
        ];
    }
}
