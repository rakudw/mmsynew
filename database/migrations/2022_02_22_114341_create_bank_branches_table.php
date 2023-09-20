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
        Schema::create('bank_branches', function (Blueprint $table) {
            $this->addIdColumn($table);

            $table->string('name');
            $table->string('address', 511);
            $table->foreignId('district_id')->constrained('regions');
            $table->foreignId('bank_id')->constrained();
            $table->string('ifsc', 15);
            $table->string('prefix', 7)->nullable();

            $this->addCommonColumns($table);

            $table->unique(['ifsc', 'prefix']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_branches');
    }
};
