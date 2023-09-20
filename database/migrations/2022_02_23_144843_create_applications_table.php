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

        Schema::create('forms', function (Blueprint $table) {
            $this->addIdColumn($table);

            $table->string('name');
            $table->foreignId('region_id')->nullable()->constrained();
            $table->unsignedBigInteger('parent_id')->nullable();

            $table->json('mappings')->nullable()->comment('Will be used for mapping columns from the application forms to preset columns.');

            $this->addCommonColumns($table);
        });

        Schema::create('form_designs', function (Blueprint $table) {
            $this->addIdColumn($table);

            $table->string('name');
            $table->string('slug');
            $table->foreignId('form_id')->constrained();
            $table->json('design');
            $table->json('validations')->nullable();
            $table->json('assets')->nullable();
            $table->tinyInteger('order')->unsigned();

            $this->addCommonColumns($table);
        });

        Schema::create('form_document_types', function (Blueprint $table) {
            $this->addIdColumn($table);

            $table->foreignId('form_id')->constrained();
            $table->foreignId('document_type_id')->constrained();
            $table->tinyInteger('order')->unsigned();
            $table->boolean('is_required')->default(false);
            $table->json('extras')->nullable();

            $this->addCommonColumns($table);
        });

        Schema::create('applications', function (Blueprint $table) {
            $this->addIdColumn($table);

            $table->string('name');
            $table->foreignId('form_id')->constrained();
            $table->json('data');
            $table->foreignId('region_id')->nullable()->constrained();
            $table->foreignId('status_id')->constrained('enums');

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
        Schema::dropIfExists(['applications', 'form_document_types', 'form_designs', 'forms']);
    }
};