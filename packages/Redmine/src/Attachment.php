<?php

namespace Aedart\Redmine;

use Aedart\Contracts\Redmine\Deletable;
use Aedart\Contracts\Redmine\Updatable;
use Aedart\Redmine\Partials\Reference;
use Carbon\Carbon;

/**
 * Attachment Resource
 *
 * @property int $id
 * @property string $filename
 * @property int $filesize
 * @property string $content_type
 * @property string|null $description
 * @property string $content_url
 * @property string $thumbnail_url
 * @property Reference $author
 * @property Carbon $created_on
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine
 */
class Attachment extends RedmineResource implements
    Updatable,
    Deletable
{
    protected array $allowed = [
        'id' => 'int',
        'filename' => 'string',
        'filesize' => 'int',
        'content_type' => 'string',
        'description' => 'string',
        'content_url' => 'string',
        'thumbnail_url' => 'string',
        'author' => Reference::class,
        'created_on' => 'date'
    ];

    /**
     * @inheritDoc
     */
    public function resourceName(): string
    {
        return 'attachments';
    }

    // TODO: Add upload logic... somehow...
}
