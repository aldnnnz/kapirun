<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pengguna>
 */
class PenggunaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => fake()->password(),
            'no_hp' => fake()->phoneNumber(),
            'referal_code' => fake()->unique()->regexify('[A-Za-z0-9]{10}'),
            'jenis_pengguna' => fake()->randomElement(['admin', 'kasir', 'pembeli']),
        ];
    }
}
