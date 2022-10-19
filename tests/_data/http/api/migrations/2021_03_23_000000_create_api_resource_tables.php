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
    }
}
