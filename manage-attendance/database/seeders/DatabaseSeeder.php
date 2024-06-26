<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Account;
use App\Models\Instructor;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            AccountSeeder::class,
            AdminSeeder::class,
            MajorSeeder::class,
            SchoolYearSeeder::class,
            ClassStudentSeeder::class,
            SubjectSeeder::class,
            StudentSeeder::class,
            InstructorSeeder::class,
            DivisionSeeder::class,
        ]);
    }
}
