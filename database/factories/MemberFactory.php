<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'category' => fake()->randomElement(['Student', 'Faculty', 'Staff']),
            'level' => fake()->randomElement(['Beginner', 'Intermediate', 'Advanced']),
            'is_active' => true,
        ];
    }
}
