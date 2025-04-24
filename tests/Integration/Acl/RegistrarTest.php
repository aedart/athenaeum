<?php

namespace Aedart\Tests\Integration\Acl;

use Aedart\Acl\Models\Permission;
use Aedart\Acl\Models\Role;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Acl\AclTestCase;
use Codeception\Attribute\Group;
use Illuminate\Database\Eloquent\Collection;
use PHPUnit\Framework\Attributes\Test;

/**
 * RegistrarTest
 *
 * @group acl
 * @group acl-registrar
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Acl
 */
#[Group(
    'acl',
    'acl-registrar',
)]
class RegistrarTest extends AclTestCase
{
    /**
     * The permissions that have been persisted
     * in the database
     *
     * @var Collection|Permission[]
     */
    protected Collection $permissions;

    /**
     * Granted permissions for test role
     *
     * @var Collection|Permission[]
     */
    protected Collection $granted;

    /**
     * Permissions that are not granted
     *
     * @var Collection|Permission[]
     */
    protected Collection $notGranted;

    /**
     * The test role
     *
     * @var Role
     */
    protected Role $role;

    /*****************************************************************
     * Setup
     ****************************************************************/

    /**
     * @inheritDoc
     */
    protected function _before()
    {
        parent::_before();

        // Forget evt. previous cached permissions
        $this->getRegistrar()->flush();

        // Create permissions
        $this->permissions = $this->createPermissionGroupWithPermissions('user')->permissions;
        $this->granted = $this->permissions->take(2);
        $this->notGranted = $this->permissions->skip(2);

        // Create role and grant permissions
        $this->role = $this->createRole();
        $this->role->grantPermissions($this->granted);
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     */
    #[Test]
    public function canDefinePermissions()
    {
        $gate = $this->getGate();
        $registrar = $this->getRegistrar();

        $registrar->define($gate);

        // ----------------------------------------------------------- //
        // Ensure abilities (permissions) are defined in access gate
        $abilities = $gate->abilities();
        $keys = array_keys($abilities);

        ConsoleDebugger::output($keys);

        $this->assertNotEmpty($abilities, 'Gate abilities are empty');
        $this->assertCount($this->permissions->count(), $abilities, 'Incorrect amount of abilities defined');

        $slugs = $this->permissions->pluck('slug')->toArray();
        $this->assertSame($slugs, $keys, 'Incorrect abilities defined');
    }

    /**
     * @test
     */
    #[Test]
    public function canDeterminePermissionForUser()
    {
        $user = $this->createUser();
        $user->assignRoles($this->role);

        // ----------------------------------------------------------- //
        // Set the Auth user and define abilities
        $this
            ->actingAs($user)
            ->getRegistrar()
            ->define($this->getGate());

        // ----------------------------------------------------------- //
        // Determine whether user has or has not specified permissions

        // Granted permissions check
        foreach ($this->granted as $permission) {
            $ability = $permission->getSlugKey();
            $result = $user->can($ability);

            $formatted = $result ? 'true' : 'false';
            ConsoleDebugger::output("User can '{$ability}'? ({$formatted})");

            $this->assertTrue($result, "User SHOULD have '{$ability}' ability");
        }

        // Not granted permissions check
        foreach ($this->notGranted as $permission) {
            $ability = $permission->getSlugKey();
            $result = $user->cant($ability);

            $formatted = $result ? 'true' : 'false';
            ConsoleDebugger::output("User cannot '{$ability}'? ({$formatted})");

            $this->assertTrue($result, "User SHOULD NOT have '{$ability}' ability");
        }
    }

    /**
     * @test
     */
    #[Test]
    public function cachesPermissions()
    {
        $registrar = $this->getRegistrar();

        // Obtain existing (cached) permissions - this simulates that
        // the permissions have already been used for defining them
        // in the access gate and thus they are cached...
        $registrar->getPermissions();

        // Save a new set of permissions in database, so
        $this->createPermissionGroupWithPermissions('notes');
        $stored = $this->aclPermissionsModel()::all();

        // (Re)obtain the permissions from the registrar - expecting the cached
        // permissions to be returned.
        $cached = $registrar->getPermissions();

        // Compared the cached vs. stored permissions
        $key = $this->aclPermissionsModelInstance()->getSlugKeyName();
        $storedSlugs = $stored->pluck($key)->toArray();
        $cachedSlugs = $cached->pluck($key)->toArray();

        ConsoleDebugger::output([
            'stored' => $storedSlugs,
            'cached' => $cachedSlugs
        ]);

        $this->assertNotSame($cachedSlugs, $storedSlugs, 'Failed to cache permissions in acl registrar');

        // ----------------------------------------------------------- //
        // Force re-obtain them
        $reObtained = $registrar
            ->getPermissions(true)
            ->pluck($key)
            ->toArray();

        ConsoleDebugger::output([
            'stored' => $storedSlugs,
            '(re)obtained' => $reObtained
        ]);

        $this->assertSame($reObtained, $storedSlugs, 'Failed to force obtain permissions in acl registrar');
    }
}
