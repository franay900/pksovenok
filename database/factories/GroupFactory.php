<?php

namespace Database\Factories;

use App\Models\Bell;
use App\Models\Organization;
use App\Models\PeriodType;
use App\Models\User;
use App\Models\Year;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group>
 */
class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $organization = Organization::all()->first();
        return [
            'number' => fake()->numberBetween(1, 11),
            'letter' => fake()->randomLetter(),
            'organization_id' => $organization->id,
            'year_id' => $organization->year->id,
            'manager_id' => User::all()->random()->id,
            'period_type_id' => PeriodType::all()->random()->id,
            'bell_id' => Bell::all()->random()->id,
        ];
    }
}
