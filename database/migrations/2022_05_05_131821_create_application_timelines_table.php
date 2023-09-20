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
        Schema::create('application_timelines', function (Blueprint $table) {
            $this->addIdColumn($table);

            $table->foreignId('application_id')->constrained();
            $table->string('remarks');
            $table->foreignId('old_status_id')->constrained('enums');
            $table->foreignId('new_status_id')->constrained('enums');
            $table->foreignId('creator_role_id')->nullable()->constrained('roles');

            $this->addCommonColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('application_timelines');
    }
};
