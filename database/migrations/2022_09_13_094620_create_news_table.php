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
        Schema::create('news', function (Blueprint $table) {
            $this->addIdColumn($table);

            $table->text('title');
            $table->char('icon', 31)->nullable();
            $table->string('image')->nullable();
            $table->string('link')->nullable();
            $table->date('start');
            $table->date('end')->nullable();
            $table->boolean('is_active')->default(true);

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
        Schema::dropIfExists('news');
    }
};
