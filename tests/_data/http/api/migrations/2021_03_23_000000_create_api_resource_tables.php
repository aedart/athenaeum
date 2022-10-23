<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Api Resource Tables
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 */
class CreateApiResourceTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();

            $table
                ->string('street');

            $table
                ->string('postal_code');

            $table
                ->string('city');

            $table->timestamps();
        });

        Schema::create('owners', function (Blueprint $table) {
            $table->id();

            $table
                ->string('name')
                ->unique();

            $table
                ->foreignId('address_id')
                ->nullable()
                ->constrained('addresses')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->timestamps();
        });

        Schema::create('games', function (Blueprint $table) {
            $table->id();

            $table
                ->string('slug')
                ->unique();

            $table
                ->string('name');

            $table->text('description')
                ->nullable();

            $table
                ->foreignId('owner_id')
                ->nullable()
                ->constrained('owners')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });

        // ----------------------------------------------------------------------------- //

        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table
                ->string('name');

            $table->timestamps();
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->id();

            $table
                ->string('name');

            $table->timestamps();
        });

        Schema::create('role_user', function (Blueprint $table) {
            $table->id();

            $table
                ->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table
                ->foreignId('role_id')
                ->constrained('roles')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique([ 'user_id', 'role_id' ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
        Schema::dropIfExists('owners');
        Schema::dropIfExists('addresses');

        Schema::dropIfExists('role_user');
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
    }
}
