<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bank_branches', function (Blueprint $table) {
            $table->string('micr_code')->nullable();
            $table->string('city_name')->nullable();
            $table->string('std_code')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('neft_enabled')->nullable();
            $table->string('rtgs_enabled')->nullable();
            $table->string('lcs_enabled')->nullable();
            $table->string('bgs_enabled')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bank_branches', function (Blueprint $table) {
            //
        });
    }
};
