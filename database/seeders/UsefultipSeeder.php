<?php

namespace Database\Seeders;

use App\Models\Usefultip;
use Illuminate\Support\Str;

class UsefultipSeeder extends BaseSeeder
{


    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Usefultip::create([
            'id' => 1,
            'description' => 'Sign up by entering Email, Phone no, Password',
            'status'  => 'Active',
        ]);
        // Create super admin user
        Usefultip::create([
            'id' => 2,
            'description' => 'IYou can use either email or phone number while login',
            'status'  => 'Active',
        ]);
        Usefultip::create([
            'id' => 3,
            'description' => 'Forgot password will send new password into your',
            'status' => 'Active',
        ]);
        Usefultip::create([
            'id' => 4,
            'description' => 'Fill application with detail which is asked in form',
            'status'  => 'Active',
        ]);
        Usefultip::create([
            'id' => 5,
            'description' => 'Aadhaar and Name will match to the original aadhar',
            'status'  => 'Active',
        ]);
        Usefultip::create([
            'id' => 6,
            'description' => 'Be careful while selecting district applying for',
            'status'  => 'Active',
        ]);
        Usefultip::create([
            'id' => 7,
            'description' => 'Age must be between 18 to 45 year old',
            'status'  => 'Active',
        ]);
        Usefultip::create([
            'id' => 8,
            'description' => 'Type of activity is depen on your nature of your',
            'status'  => 'Active',
        ]);
        Usefultip::create([
            'id' => 9,
            'description' => 'Qualification is beneficial for choosing industry',
            'status'  => 'Active',
        ]);
        Usefultip::create([
            'id' => 10,
            'description' => 'Land cost estimate will be mandatory',
            'status'  => 'Active',
        ]);
        Usefultip::create([
            'id' => 11,
            'description' => 'You must not be a defaulter in any bank',
            'status'  => 'Active',
        ]);
        Usefultip::create([
            'id' => 12,
            'description' => 'Land Record and PPR is in PDF format and allowed size',
            'status'  => 'Active',
        ]);
        Usefultip::create([
            'id' => 13,
            'description' => 'From security option you can update your password',
            'status'  => 'Active',
        ]);
        Usefultip::create([
            'id' => 14,
            'description' => 'With the help of bell icon you will know about the
            status of application',
            'status'  => 'Active',
        ]);
        Usefultip::create([
            'id' => 15,
            'description' => 'You can choose any bank in bank info',
            'status'  => 'Active',
        ]);
    }
}
