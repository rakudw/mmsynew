<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BaseSeeder extends Seeder
{

    protected function walk(array $array, $callback) {
        array_walk($array, $callback);
    }
}