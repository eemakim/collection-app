<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            DB::table('cars')->insert([
                'make' => Str::random(10),
                'model' => Str::random(15),
                'year' => rand(1950, 2024),
                'number_plate' => strtoupper(Str::random(7)),
                'weight' => rand(900, 3000),
                'electric' => rand(0,1)

            ]);
        }
    }
}
