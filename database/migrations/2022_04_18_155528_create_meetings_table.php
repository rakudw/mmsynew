<?php

use Database\Helpers\MigrationTrait;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    use MigrationTrait;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $this->addIdColumn($table);

            $table->string('title', 255);
            $table->foreignId('district_id')->constrained('regions');
            $table->timestamp('datetime');
            $table->boolean('was_conducted')->default(false);
            $table->string('chair_person', 255);
            $table->string('remarks', 255)->nullable();
            $table->foreignId('proceeding_id')->nullable()->constrained('documents');

            $this->addCommonColumns($table);
        });

        Schema::create('meeting_applications', function (Blueprint $table) {
            $this->addIdColumn($table);

            $table->foreignId('meeting_id')->constrained();
            $table->foreignId('application_id')->constrained();

            $table->string('remarks', 255)->nullable();
            $table->enum('status', ['PENDING', 'APPROVED', 'REJECTED', 'DEFERRED'])->default('PENDING');

            $this->addCommonColumns($table);

            $table->unique(['meeting_id', 'application_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meeting_applications');
        Schema::dropIfExists('meetings');
    }
};
