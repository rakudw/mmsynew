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
        Schema::create('banners', function (Blueprint $table) {
            $this->addIdColumn($table);
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('minister_image')->nullable();
            $table->string('cm_image')->nullable();
            $table->string('status', 100)->nullable();
            $table->string('type', 100)->nullable();
            $table->integer('year')->nullable();
            $table->string('link')->nullable();
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
        Schema::dropIfExists('banners');
    }
};

