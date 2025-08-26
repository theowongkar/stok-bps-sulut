<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       return [
            'user_id' => null,
            'nip' => fake()->unique()->numerify('1980######'),
            'name' => fake()->name(),
            'gender' => fake()->randomElement(['Laki-Laki', 'Perempuan']),
            'department' => fake()->randomElement(['Kepegawaian', 'Keuangan', 'IPDS']),
            'phone' => fake()->phoneNumber(),
            'avatar' => null,
        ];
    }
}
