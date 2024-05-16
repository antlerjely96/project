<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Account::create([
            'email' => 'admin@test.gmail.com',
            'password' => bcrypt('123456'),
            'role' => '1',
            'locked' => '0',
        ]);

        Account::create([
            'email' => 'instructor@test.gmail.com',
            'password' => bcrypt('123456'),
            'role' => '2',
            'locked' => '0',
        ]);

        Account::create([
            'email' => 'student@test.gmail.com',
            'password' => bcrypt('123456'),
            'role' => '3',
            'locked' => '0',
        ]);
    }
}
