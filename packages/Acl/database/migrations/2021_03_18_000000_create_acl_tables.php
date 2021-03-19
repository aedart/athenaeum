<?php

use Aedart\Acl\Traits\AclComponentsTrait;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Acl Tables Database Migration
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 */
class CreateAclTables extends Migration
{
    use AclComponentsTrait;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create Permission Groups table
        Schema::create($this->aclTable('groups'), function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique('permission_groups_slug')->comment('Unique string identifier');
            $table->string('name')->comment('Name of permission group');
            $table->text('description')->nullable()->comment('Evt. description of group');
            $table->timestamps();
            $table->softDeletes();
        });

        // Create Permissions table
        Schema::create($this->aclTable('permissions'), function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor($this->aclPermissionsGroupModel())
                ->constrained($this->aclTable('groups'))
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('slug')->unique('permissions_slug')->comment('Unique string identifier');
            $table->string('name')->comment('Name of permission');
            $table->text('description')->nullable()->comment('Evt. description of permission');
            $table->timestamps();
        });

        // Create Roles table
        Schema::create($this->aclTable('roles'), function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique('roles_slug')->comment('Unique string identifier');
            $table->string('name')->comment('Name of role');
            $table->text('description')->nullable()->comment('Evt. description of role');
            $table->timestamps();
            $table->softDeletes();
        });

        // Create Roles Permissions pivot table
        Schema::create($this->aclTable('roles_permissions'), function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor($this->aclRoleModel())
                ->constrained($this->aclTable('roles'))
                ->cascadeOnDelete();

            $table->foreignIdFor($this->aclPermissionsModel())
                ->constrained($this->aclTable('permissions'))
                ->cascadeOnDelete();

            $table->timestamps();

            $roleId = (new ($this->aclRoleModel()))->getForeignKey();
            $permissionId = (new ($this->aclPermissionsModel()))->getForeignKey();
            $table->unique([$roleId, $permissionId], 'role_permission');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->aclTable('roles_permissions'));
        Schema::dropIfExists($this->aclTable('roles'));
        Schema::dropIfExists($this->aclTable('permissions'));
        Schema::dropIfExists($this->aclTable('groups'));
    }
}
