<?php

namespace Aedart\Acl\Models\Permissions;

use Aedart\Acl\Models\Concerns as AclConcerns;
use Aedart\Acl\Models\Permission;
use Aedart\Contracts\Database\Models\Sluggable;
use Aedart\Database\Model;
use Aedart\Database\Models\Concerns;
use Aedart\Utils\Str;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * Permission Group
 *
 * @property int $id Unique identifier
 * @property string $slug Unique string identifier
 * @property string $name Name of permission group
 * @property string|null $description Evt. description of permission group
 * @property Carbon $created_at Date and time of when record was created
 * @property Carbon $updated_at Date and time of when record was last updated
 * @property Carbon|null $deleted_at Evt. date and time of when record was soft-deleted
 *
 * @property Permission[]|Collection $permissions The permissions that belong to this group
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Acl\Models\Permissions
 */
class Group extends Model implements Sluggable
{
    use SoftDeletes;
    use AclConcerns\AclModels;
    use Concerns\Slugs;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = ['id'];

    /**
     * @inheritdoc
     */
    public function __construct(array $attributes = [])
    {
        $this->table = $this->aclTable('groups');

        parent::__construct($attributes);
    }

    /*****************************************************************
     * Operations
     ****************************************************************/

    /**
     * Creates a permission group with given permissions.
     *
     * If a group already exists with given slug, then the existing group
     * will be used.
     *
     * <code>
     * Group::createWithPermissions('users', [
     *      'index' => [ 'name' => 'List', 'description' => 'Ability to see list of users' ],
     *      'show' => [ 'name' => 'Read', 'description' => 'Ability to see individual users' ],
     *      'store' => [ 'name' => 'Create', 'description' => 'Ability to create new users' ],
     *      'update' => [ 'name' => 'Update', 'description' => 'Ability to update...' ],
     *      'delete' => [ 'name' => 'Delete', 'description' => 'Ability to delete...' ],
     * ]);
     * </code>
     *
     * @param string $slug
     * @param array $permissions List of permissions to create. Key = slug, value = array with name and description
     * @param string|null $name [optional] Group's name. If none given, then slug is converted
     *                          into words and used as group's name.
     * @param string|null $description [optional] Evt. description of group
     * @param bool $prefix [optional] If true, each permission's slug is prefixed with the group's
     *                     slug, using dot as separator.
     *
     * @return static
     *
     * @throws Throwable
     */
    public static function createWithPermissions(
        string $slug,
        array $permissions,
        ?string $name = null,
        ?string $description = null,
        bool $prefix = true
    ) {
        // Method is intended to streamline creation of permissions for
        // a specific group. Since multiple permissions can be requested
        // created, we use database transactions for this method.

        DB::beginTransaction();
        try {
            // Find or create permissions group
            $group = static::findOrCreateBySlug($slug, [
                'name' => $name ?? (string) Str::slugToWords($slug)->ucfirst(),
                'description' => $description
            ]);

            // Prepare the permissions for bulk insert. Prefix each permission's slug,
            // with group's slug, if required.
            $prepared = static::preparePermissionsForBulkInsert($permissions, $group, $prefix);

            // Perform bulk insert
            static::make()->aclPermissionsModel()::insert($prepared);

            DB::commit();
            return $group;
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /*****************************************************************
     * Relations
     ****************************************************************/

    /**
     * The permissions that belong to this group
     *
     * @return HasMany
     */
    public function permissions(): HasMany
    {
        return $this->hasMany($this->aclPermissionsModel());
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Prepares given permissions to be bulk inserted into the database
     *
     * @param array $permissions
     * @param Group $group
     * @param bool $prefix [optional]
     *
     * @return array
     */
    protected static function preparePermissionsForBulkInsert(array $permissions, Group $group, bool $prefix = true): array
    {
        $output = [];

        foreach ($permissions as $key => $value) {
            $slug = $prefix ? $group->slug . '.' . $key : $key;
            $name = $value['name'] ?? (string) Str::slugToWords($slug)->ucfirst();
            $description = $value['description'] ?? null;
            $now = Carbon::now();

            $output[] = [
                'group_id' => $group->id,
                'slug' => $slug,
                'name' => $name,
                'description' => $description,

                // Since we perform a bulk insert, we also need to specify the timestamps manually.
                'created_at' => $now,
                'updated_at' => $now
            ];
        }

        return $output;
    }
}
