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
        Schema::create('regions', function (Blueprint $table) {
            $this->addIdColumn($table);

            $table->string('name', 255);
            $table->foreignId('type_id')->constrained('enums');
            $table->unsignedBigInteger('parent_id')->nullable();

            $this->addCommonColumns($table);

            $table->unique(['name', 'type_id', 'parent_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regions');
    }
};
