<?php

namespace Database\Factories;

use App\Models\ClassStudent;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => 'BKC12' . $this->faker->numberBetween(100, 999),
            'name' => $this->faker->name,
            'phone' => $this->faker->e164PhoneNumber,
            'address' => $this->faker->address,
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'date_of_birth' => $this->faker->date('Y-m-d', '2004-01-01'),
            'class_student_id' => $this->faker->randomElement(ClassStudent::all()->pluck('id')),
            'account_id' => 3,
        ];
    }
}
