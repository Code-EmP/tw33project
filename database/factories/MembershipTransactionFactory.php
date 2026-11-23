<?php

namespace Database\Factories;

use App\Models\Member;
use App\Models\MembershipLevel;
use App\Models\MembershipTransaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MembershipTransaction>
 */
class MembershipTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'member_id' => Member::factory(), 'membership_level_id' => MembershipLevel::factory(),
            'transaction_type' => 'new', 'amount' => 500, 'payment_method' => 'demo_card',
            'payment_reference' => 'DEMO-'.fake()->unique()->numerify('######'),
            'payment_status' => 'paid', 'approval_status' => 'approved', 'paid_at' => now(),
            'approved_at' => now(), 'starts_at' => now(), 'expires_at' => now()->addYear(),
        ];
    }
}
