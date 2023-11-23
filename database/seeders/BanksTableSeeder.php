<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BanksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banks = [
            ['name' => 'RBL BANK LIMITED', 'type_id' => 502, 'ifsc' => null, 'created_by' => 0],
            ['name' => 'RBI PAD, AHMEDABAD', 'type_id' => 502, 'ifsc' => null, 'created_by' => 0],
            ['name' => 'RESERVE BANK OF INDIA', 'type_id' => 502, 'ifsc' => null, 'created_by' => 0],
            ['name' => 'UTKARSH SMALL FINANCE BANK', 'type_id' => 502, 'ifsc' => null, 'created_by' => 0],
            ['name' => 'CAPITAL SMALL FINANCE BANK LIMITED', 'type_id' => 502, 'ifsc' => null, 'created_by' => 0],
            ['name' => 'EQUITAS SMALL FINANCE BANK LIMITED', 'type_id' => 502, 'ifsc' => null, 'created_by' => 0],
            ['name' => 'FEDERAL BANK', 'type_id' => 502, 'ifsc' => null, 'created_by' => 0],
            ['name' => 'FINO PAYMENTS BANK', 'type_id' => 502, 'ifsc' => null, 'created_by' => 0],
            ['name' => 'IDFC FIRST BANK LTD', 'type_id' => 502, 'ifsc' => null, 'created_by' => 0],
        ];

        // Insert the data into the 'banks' table
        DB::table('banks')->insert($banks);
    }
}
