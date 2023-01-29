<?php

use Aedart\Audit\Concerns\AuditTrailConfig;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;
use Illuminate\Support\Facades\Schema;

/**
 * Create Audit Trail Table Migration
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 */
class CreateAuditTrailTable extends Migration
{
    use AuditTrailConfig;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->auditTrailTable(), function (Blueprint $table) {
            $table->id();

            // User foreign-key. NOTE: Must be nullable, in case that user
            // is deleted / force-deleted.
            $user = $this->auditTrailUserModelInstance();
            $table->foreignIdFor($this->auditTrailUserModel())
                ->nullable()
                ->comment('The user that caused this action, event or data change')
                ->constrained($user->getTable())
                ->nullOnDelete();

            // Target model that has changed
            $table->morphs('auditable');

            $table->string('type')
                ->comment('Action or event type, e.g. created, updated... etc');

            $table->text('message')
                ->nullable()
                ->comment('Eventual description or message about why action or event was caused');

            $this->makeAttributesColumn($table, 'original_data')
                ->nullable()
                ->comment('The original data, before any changes were made');

            $this->makeAttributesColumn($table, 'changed_data')
                ->nullable()
                ->comment('Data after changes have been made');

            $table->timestamp('performed_at')->comment('Date and time of when action or event happened');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->auditTrailTable());
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Returns a new "attributes" column
     *
     * @param Blueprint $table
     * @param string $name
     *
     * @return ColumnDefinition
     */
    protected function makeAttributesColumn(Blueprint $table, string $name): ColumnDefinition
    {
        $type = $this->auditTableAttributesColumnType();

        return $table->{$type}($name);
    }
}
