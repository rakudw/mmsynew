<?php

namespace Database\Helpers;

use Illuminate\Database\Schema\Blueprint;

trait MigrationTrait
{

    public function addIdColumn(Blueprint $table)
    {
        $table->id()->unsigned();
        return $table;
    }

    public function addCommonColumns(Blueprint $table)
    {
        $table->timestamp('created_at')->useCurrent();
        $table->timestamp('updated_at')->nullable();
        $table->softDeletes();
        $table->foreignId('created_by')->constrained('users');
        $table->foreignId('updated_by')->nullable()->constrained('users');
        $table->foreignId('deleted_by')->nullable()->constrained('users');

        return $table;
    }

}
