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
        Schema::create('games', function (Blueprint $table) {
            $table->id();

            $table
                ->string('slug')
                ->unique();

            $table
                ->string('name');

            $table->text('description')
                ->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('owners', function (Blueprint $table) {
            $table->id();

            $table
                ->string('name')
                ->unique();

            $table->timestamps();
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
    }
}
