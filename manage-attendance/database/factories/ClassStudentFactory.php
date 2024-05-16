<?php

namespace Database\Factories;

use App\Models\Major;
use App\Models\SchoolYear;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClassStudent>
 */
class ClassStudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' =>$this->faker->name,
            'major_id' => $this->faker->randomElement(Major::all()->pluck('id')),
            'school_year_id' => $this->faker->randomElement(SchoolYear::all()->pluck('id')),
        ];
    }
}
