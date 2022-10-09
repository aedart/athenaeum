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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique('slug_unq')->comment('Unique string identifier');
            $table->string('name')->comment('Name of category');
            $table->text('description')->nullable()->comment('Evt. description of category');
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
        Schema::dropIfExists('categories');
    }
}
