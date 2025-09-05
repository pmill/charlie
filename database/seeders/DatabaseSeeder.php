<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(5)
            ->hasCustomers(30)
            ->create([
                'password' => bcrypt('password'),
            ]);

        User::factory(1)
            ->hasCustomers(300)
            ->create([
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
            ]);
    }
}
