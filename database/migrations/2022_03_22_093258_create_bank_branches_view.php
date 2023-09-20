<?php

use App\Models\BankBranch;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        $this->down();
        $query = DB::table('bank_branches')
            ->join('banks', 'bank_branches.bank_id', '=', 'banks.id')
            ->join('regions', 'bank_branches.district_id', '=', 'regions.id')
            ->select(['bank_branches.id', DB::raw("CONCAT(CASE WHEN `bank_branches`.`prefix` IS NULL OR TRIM(`bank_branches`.`prefix`) = '' THEN `bank_branches`.`ifsc` ELSE CONCAT(`bank_branches`.`ifsc`, ' - ', `bank_branches`.`prefix`) END, ' - ', `bank_branches`.`name`, ' - ', `banks`.`name`) `name`"), 'bank_branches.address', 'bank_branches.bank_id', 'bank_branches.district_id', DB::raw("`regions`.`name` `district_name`")]);

        DB::statement('CREATE VIEW `view_bank_branches` AS ' . $query->toSql());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS `view_bank_branches`');
    }
};
