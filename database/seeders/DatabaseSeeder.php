<?php

namespace Database\Seeders;

use App\Helpers\CacheHelper;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends BaseSeeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        CacheHelper::purge();
        $this->call([
            UserSeeder::class,
            EnumSeeder::class,
            RoleSeeder::class,
            ActivitySeeder::class,
            RegionSeeder::class,
            PostOfficeSeeder::class,
            BankSeeder::class,
            BankBranchSeeder::class,
            ApplicationSeeder::class,
            DocumentSeeder::class,
        ]);
    }
}
