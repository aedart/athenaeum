<?php

namespace Aedart\Redmine;

use Aedart\Contracts\Redmine\Creatable;
use Aedart\Contracts\Redmine\Deletable;
use Aedart\Contracts\Redmine\Listable;
use Aedart\Contracts\Redmine\Updatable;
use Aedart\Redmine\Partials\CustomFieldReference;
use Aedart\Redmine\Partials\ListOfCustomFieldReferences;
use Aedart\Redmine\Partials\ListOfMembershipReferences;
use Aedart\Redmine\Partials\ListOfReferences;
use Aedart\Redmine\Partials\MembershipReference;
use Aedart\Redmine\Partials\Reference;
use Aedart\Redmine\Relations\HasMany;
use Carbon\Carbon;

/**
 * User Resource
 *
 * @see https://www.redmine.org/projects/redmine/wiki/Rest_Users
 *
 * @property int $id
 * @property string $login
 * @property bool $admin
 * @property string $firstname
 * @property string $lastname
 * @property string $mail
 * @property string|null $api_key
 * @property int $status
 * @property Carbon $created_on
 * @property Carbon $last_login_on
 * @property ListOfCustomFieldReferences<CustomFieldReference>|CustomFieldReference[]|null $custom_fields
 *
 * @property string $password Property only available or expected when creating or updating resource.
 * @property int $auth_source_id Property only available or expected when creating or updating resource.
 * @property string $mail_notification Property only available or expected when creating or updating resource.
 * @property int[] $notified_project_ids Property only available or expected when creating or updating resource.
 * @property bool $must_change_passwd Property only available or expected when creating or updating resource.
 * @property bool $generate_password Property only available or expected when creating or updating resource.
 *
 * @property ListOfReferences<Reference>|Reference[]|null $groups Related data that can be requested included.
 * @property ListOfMembershipReferences<MembershipReference>|MembershipReference[]|null $memberships Related data that can be requested included.
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine
 */
class User extends RedmineApiResource implements
    Listable,
    Creatable,
    Updatable,
    Deletable
{
    /**
     * Anonymous user status - predefined by Redmine
     *
     * @see https://www.redmine.org/projects/redmine/repository/entry/trunk/app/models/principal.rb
     */
    public const STATUS_ANONYMOUS = 0;

    /**
     * Active user status - predefined by Redmine
     *
     * @see https://www.redmine.org/projects/redmine/repository/entry/trunk/app/models/principal.rb
     */
    public const STATUS_ACTIVE = 1;

    /**
     * Registered user status - predefined by Redmine
     *
     * @see https://www.redmine.org/projects/redmine/repository/entry/trunk/app/models/principal.rb
     */
    public const STATUS_REGISTERED = 2;

    /**
     * Locked user status - predefined by Redmine
     *
     * @see https://www.redmine.org/projects/redmine/repository/entry/trunk/app/models/principal.rb
     */
    public const STATUS_LOCKED = 3;

    /**
     * List of available user status
     */
    public const STATUS_LIST = [
        self::STATUS_ANONYMOUS,
        self::STATUS_ACTIVE,
        self::STATUS_REGISTERED,
        self::STATUS_LOCKED
    ];

    /**
     * All events - mail notification mode
     */
    public const ALL_MAIL_NOTIFICATION = 'all';

    /**
     * Selected Projects Only - mail notification mode
     *
     * NOTE: When this mode is selected, then `notified_project_ids` property is
     * expected.
     */
    public const SELECTED_MAIL_NOTIFICATION = 'selected';

    /**
     * Only user's events - mail notification mode
     */
    public const ONLY_MY_EVENTS_MAIL_NOTIFICATION = 'only_my_events';

    /**
     * Only assigned - mail notification mode
     */
    public const ONLY_ASSIGNED_MAIL_NOTIFICATION = 'only_assigned';

    /**
     * Only owner - mail notification mode
     */
    public const ONLY_OWNER_MAIL_NOTIFICATION = 'only_owner';

    /**
     * None - mail notification mode
     */
    public const NONE_MAIL_NOTIFICATION = 'none';

    /**
     * List of available mail notification modes
     */
    public const MAIL_NOTIFICATIONS_LIST = [
        self::ALL_MAIL_NOTIFICATION,
        self::SELECTED_MAIL_NOTIFICATION,
        self::ONLY_MY_EVENTS_MAIL_NOTIFICATION,
        self::ONLY_ASSIGNED_MAIL_NOTIFICATION,
        self::ONLY_OWNER_MAIL_NOTIFICATION,
        self::NONE_MAIL_NOTIFICATION
    ];

    protected array $allowed = [
        'id' => 'int',
        'login' => 'string',
        'admin' => 'bool',
        'firstname' => 'string',
        'lastname' => 'string',
        'mail' => 'string',
        'created_on' => 'date',
        'last_login_on' => 'date',
        'api_key' => 'string',
        'status' => 'int',
        'custom_fields' => ListOfCustomFieldReferences::class,

        // Only when creating or updating
        'password' => 'string',
        'auth_source_id' => 'int',
        'mail_notification' => 'string',
        'notified_project_ids' => 'array',
        'must_change_passwd' => 'bool',
        'generate_password' => 'bool',

        // Related (can be included)
        'groups' => ListOfReferences::class,
        'memberships' => ListOfMembershipReferences::class
    ];

    /**
     * @inheritDoc
     */
    public function resourceName(): string
    {
        return 'users';
    }

    /*****************************************************************
     * Relations
     ****************************************************************/

    /**
     * Issues that have been authored by this user
     *
     * @return HasMany<Issue>
     */
    public function authoredIssues(): HasMany
    {
        return $this->hasMany(Issue::class, 'author_id');
    }

    /**
     * Issues that are assigned directly to this user
     *
     * @return HasMany<Issue>
     */
    public function assignedIssues(): HasMany
    {
        return $this->hasMany(Issue::class, 'assigned_to_id');
    }
}
