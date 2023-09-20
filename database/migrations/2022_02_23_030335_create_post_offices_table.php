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
        Schema::create('post_offices', function (Blueprint $table) {
            $this->addIdColumn($table);

            $table->string('name');
            $table->string('pincode');
            $table->foreignId('district_id')->constrained('regions');
            $table->foreignId('block_id')->nullable()->constrained('regions');
            $table->foreignId('tehsil_id')->nullable()->constrained('regions');

            $this->addCommonColumns($table);

            $table->unique(['name', 'pincode']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_offices');
    }
};
