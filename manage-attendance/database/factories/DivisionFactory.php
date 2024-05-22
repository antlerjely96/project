<?php

namespace Database\Factories;

use App\Models\ClassStudent;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Division>
 */
class DivisionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'class_student_id' => $this->faker->randomElement(ClassStudent::all()->pluck('id')),
            'subject_id' => $this->faker->randomElement(Subject::all()->pluck('id')),
            'instructor_id' => '2',
            'admin_id' => '1',
            'status' => '0',
        ];
    }
}
