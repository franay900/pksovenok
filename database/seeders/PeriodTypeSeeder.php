<?php

namespace Database\Seeders;

use App\Models\PeriodType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeriodTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PeriodType::create(['name'=>'четверть', 'name_many'=>'четверти', 'quantity'=>4]);
        PeriodType::create(['name'=>'триместр', 'name_many'=>'триместры', 'quantity'=>3]);
        PeriodType::create(['name'=>'полугодие', 'name_many'=>'полугодия', 'quantity'=>2]);
    }
}
