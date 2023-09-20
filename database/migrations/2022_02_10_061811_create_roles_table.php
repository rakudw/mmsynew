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
        Schema::create('roles', function (Blueprint $table) {
            $this->addIdColumn($table);

            $table->string('name', 31);
            $table->json('metadata')->nullable()->comment('{"pendency_application_status_ids":[]}');

            $this->addCommonColumns($table);
        });

        Schema::create('permissions', function (Blueprint $table) {
            $this->addIdColumn($table);

            $table->string('name', 31);
            $table->string('slug', 31)->unique();

            $this->addCommonColumns($table);
        });

        Schema::create('user_roles', function (Blueprint $table) {
            $this->addIdColumn($table);

            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('role_id')->constrained('roles');
            $table->json('metadata')->nullable()->comment('{"region_ids":[], "bank_branch_ids":[], "bank_ids":[]}');

            $this->addCommonColumns($table);

            $table->unique(['user_id','role_id']);
        });

        Schema::create('role_permissions', function (Blueprint $table) {
            $this->addIdColumn($table);

            $table->foreignId('role_id')->constrained('roles');
            $table->foreignId('permission_id')->constrained('permissions');

            $this->addCommonColumns($table);

            $table->unique(['role_id','permission_id']);
        });

        Schema::create('user_permissions', function (Blueprint $table) {
            $this->addIdColumn($table);

            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('permission_id')->constrained('permissions');

            $this->addCommonColumns($table);

            $table->unique(['user_id','permission_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(['roles', 'permissions', 'user_roles', 'user_permissions']);
    }
};
