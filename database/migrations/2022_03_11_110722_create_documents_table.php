<?php

use Database\Helpers\MigrationTrait;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('documents', function (Blueprint $table) {
            $this->addIdColumn($table);

            $table->string('name', 127);
            $table->binary('content');
            $table->string('mime', 127);
            $table->string('hash', 127);

            $this->addCommonColumns($table);
        });

        DB::statement("ALTER TABLE `documents` CHANGE `content` `content` LONGBLOB NOT NULL AFTER `id`");

        Schema::create('application_documents', function (Blueprint $table) {
            $this->addIdColumn($table);

            $table->foreignId('application_id')->constrained();
            $table->foreignId('document_id')->constrained();
            $table->foreignId('document_type_id')->nullable()->constrained();
            $table->string('document_name', 63);

            $this->addCommonColumns($table);

            $table->unique(['application_id', 'document_id', 'document_type_id', 'document_name'], 'application_type_name_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('application_documents');
        Schema::dropIfExists('documents');
    }
};
