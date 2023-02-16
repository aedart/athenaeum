<?php

namespace Aedart\Redmine;

use Aedart\Contracts\Redmine\Connection;
use Aedart\Contracts\Redmine\Deletable;
use Aedart\Redmine\Relations\BelongsTo;
use InvalidArgumentException;
use JsonException;
use Throwable;

/**
 * Issue Relation Resource
 *
 * @see https://www.redmine.org/projects/redmine/wiki/Rest_IssueRelations
 *
 * @property int $id
 * @property int $issue_id
 * @property int $issue_to_id
 * @property string $relation_type
 * @property float $delay
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Redmine
 */
class Relation extends RedmineApiResource implements
    Deletable
{
    /**
     * Relates relation type (default)
     */
    public const RELATES = 'relates';

    /**
     * Duplicates relation type
     */
    public const DUPLICATES = 'duplicates';

    /**
     * Duplicated relation type
     */
    public const DUPLICATED = 'duplicated';

    /**
     * Blocks relation type
     */
    public const BLOCKS = 'blocks';

    /**
     * Blocked relation type
     */
    public const BLOCKED = 'blocked';

    /**
     * Precedes relation type
     */
    public const PRECEDES = 'precedes';

    /**
     * Follows relation type
     */
    public const FOLLOWS = 'follows';

    /**
     * Copied to relation type
     */
    public const COPIED_TO = 'copied_to';

    /**
     * Copied from relation type
     */
    public const COPIED_FROM = 'copied_from';

    /**
     * Supported relation types
     */
    public const RELATION_TYPES = [
        self::RELATES,
        self::DUPLICATES,
        self::DUPLICATED,
        self::BLOCKS,
        self::BLOCKED,
        self::PRECEDES,
        self::FOLLOWS,
        self::COPIED_TO,
        self::COPIED_FROM,
    ];

    protected array $allowed = [
        'id' => 'int',
        'issue_id' => 'int',
        'issue_to_id' => 'int',
        'relation_type' => 'string',
        'delay' => 'float',
    ];

    /**
     * @inheritDoc
     */
    public function resourceName(): string
    {
        return 'relations';
    }

    /**
     * Create a new relation between two issues
     *
     * @param int $parent Parent issue id
     * @param int $related Related issue id
     * @param string $type [optional] Type of relation
     * @param float|null $delay [optional] The delay (days) for a "precedes" or "follows" relation
     * @param string|Connection|null $connection [optional] Redmine connection profile
     *
     * @return static
     *
     * @throws JsonException
     * @throws Throwable
     */
    public static function createRelation(
        int $parent,
        int $related,
        string $type = self::RELATES,
        float|null $delay = null,
        string|Connection|null $connection = null
    ): static {
        $resource = static::make([
            'issue_id' => $parent,
            'issue_to_id' => $related,
            'relation_type' => $type,
            'delay' => $delay,
        ], $connection);

        $url = "issues/{$parent}/relations.json";
        $payload = [
            $resource->resourceNameSingular() => $resource->toArray()
        ];

        $response = $resource
            ->request()
            ->post($url, $payload);

        return $resource->fill(
            $resource->decodeSingle($response)
        );
    }

    /**
     * Set the relation type property
     *
     * @param string|null $type [optional]
     *
     * @return self
     */
    public function setRelationType(string|null $type = null): static
    {
        if (isset($type) && !in_array($type, static::RELATION_TYPES)) {
            throw new InvalidArgumentException(sprintf('%s is not a supported relation type', $type));
        }

        $this->properties['relation_type'] = $type;

        return $this;
    }

    /*****************************************************************
     * Relations
     ****************************************************************/

    /**
     * The parent issue
     *
     * @return BelongsTo<Issue>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Issue::class)
            ->foreignKey($this->issue_id);
    }

    /**
     * The related issue
     *
     * @return BelongsTo<Issue>
     */
    public function related(): BelongsTo
    {
        return $this->belongsTo(Issue::class)
            ->foreignKey($this->issue_to_id);
    }
}
