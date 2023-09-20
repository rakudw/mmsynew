<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;

class UserSeeder extends BaseSeeder
{

    const DEFAULT_PASSWORD = 'P@55w0rd';

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create auto user ...
        $autoUser = User::create([
            'name' => 'Auto System',
            'email' => 'admin@mmsy.hp.gov.in',
            'email_verified_at' => now(),
            'password' => self::DEFAULT_PASSWORD . random_int(1000, 9999),
            'remember_token' => Str::random(10),
        ]);
        $autoUser->update([
            'id' => 0
        ]);
        // Create super admin user
        User::create([
            'id' => 1,
            'name' => 'Rashid Mohamad',
            'email' => 'rashid.mohamad@hp.nic.in',
            'email_verified_at' => now(),
            'mobile' => '9418767724',
            'mobile_verified_at' => now(),
            'password' => self::DEFAULT_PASSWORD,
            'remember_token' => Str::random(10),
        ]);
        // Create super admin user
        User::create([
            'id' => 3,
            'name' => 'SAdmin',
            'email' => 'sadmin@gmail.com',
            'email_verified_at' => now(),
            'mobile' => '7018286918',
            'mobile_verified_at' => now(),
            'password' => "password",
            'remember_token' => Str::random(10),
        ]);
    }
}
