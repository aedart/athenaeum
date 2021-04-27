<?php

use Aedart\Audit\Models\Concerns;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Audit Trail Table Migration
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 */
class CreateAuditTrailTable extends Migration
{
    use Concerns\AuditTrailConfiguration;

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

            $table->json('original_data')
                ->nullable()
                ->comment('The original data, before any changes were made');

            $table->json('changed_data')
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
}
