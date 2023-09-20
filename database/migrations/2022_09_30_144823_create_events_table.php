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
        Schema::create('events', function (Blueprint $table) {
            $this->addIdColumn($table);

            $table->date('date');
            $table->string('description')->nullable();
            $table->boolean('is_holiday')->default(false);
            $table->boolean('should_flash')->default(false);
            $table->string('message')->nullable();

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
        Schema::dropIfExists('events');
    }
};
