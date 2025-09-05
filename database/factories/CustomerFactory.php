<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => ltrim($this->faker->e164PhoneNumber(), '+'),
            'organisation' => $this->faker->company(),
            'job_title' => $this->faker->jobTitle(),
            'date_of_birth' => $this->faker->date(),
            'notes' => $this->faker->paragraph(),
        ];
    }
}
