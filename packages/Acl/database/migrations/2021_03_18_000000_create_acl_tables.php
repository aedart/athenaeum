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
        Schema::create($this->aclTable('groups'), function(Blueprint $table) {
            $table->id();
            $table->string('slug')->unique('permission_groups_slug');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->aclTable('groups'));
    }
}
