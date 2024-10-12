<?php

namespace Database\Seeders;

use App\Models\Year;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class YearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Year::create([
            'name' => '2024/2025 учебный год',
            'begin' => '01.09.2024',
            'end' => '31.05.2024'
        ]);
    }
}
