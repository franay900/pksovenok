<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subjects')->insert([
            [
                'name' => 'Математика',
                'short_name' => 'Математика',

            ],
            [
                'name' => 'Русский язык',
                'short_name' => 'Русский язык',

            ],
            [
                'name' => 'Биология',
                'short_name' => 'Биология',

            ],

            [
                'name' => 'Литература',
                'short_name' => 'Литература',

            ],

            [
                'name' => 'Физика',
                'short_name' => 'Физика',

            ],
            [
                'name' => 'Химия',
                'short_name' => 'Химия',

            ],
            [
                'name' => 'История',
                'short_name' => 'История',

            ],

            [
                'name' => 'География',
                'short_name' => 'География',

            ],

            [
                'name' => 'Обществознание',
                'short_name' => 'Обществознание',

            ],
            [
                'name' => 'Иностранный (английский) язык',
                'short_name' => 'Англ. яз.',

            ],
            [
                'name' => 'Физическая культура ',
                'short_name' => 'Физкультура',

            ],
            [
                'name' => 'Информатика',
                'short_name' => 'Информатика',

            ],

            [
                'name' => 'Изобразительное искусство',
                'short_name' => 'ИЗО',

            ],

            [
                'name' => 'Музыка',
                'short_name' => 'Музыка',

            ],

            // Добавьте больше записей по мере необходимости
        ]);
    }
}
