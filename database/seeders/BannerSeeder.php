<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Support\Str;

class BannerSeeder extends BaseSeeder
{


    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Banner::create([
            'id' => 1,
            'title' => 'HIMACHALI ENTREPRENEURS',
            'description' => 'Investment Subsidy @ 25% of investment upto a maximum investment ceiling of Rs. 60 lakh in plant &
            machinery (or equipments) with total project cost not exceeding Rs. 100 lakh (including working
            capital). Investment subsidy limit would be 30% to Scheduled Castes & Scheduled Tribes and 35% to all
            women led enterprise & Divyangjan beneficiaries.',
            'type' => 'Front',
            'status' => 'Active'
        ]);
        Banner::create([
            'id' => 2,
            'title' => '1000+ APPLICATIONS APPROVED',
            'description' => 'All those candidates who are unemployed and can establish their own employment can take advantage of Mukhyamantri Swavalamban Yojana . The scheme was started from 9 February 2019.Under the Mukhyamantri Swalamban Yojana, land will be given by the government at a very cheap rate for setting up industries. Projects up to Rs 60 lakh will be covered under the scheme.',
            'type' => 'Front',
            'status' => 'Active'
        ]);
    }
}
