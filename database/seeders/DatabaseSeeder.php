<?php

namespace Database\Seeders;

use App\Models\MembershipCategory;
use App\Models\MembershipLevel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $category = MembershipCategory::firstOrCreate(
            ['name' => 'General'],
            ['description' => 'Default member category', 'is_active' => true],
        );

        foreach ([
            ['name' => 'Basic', 'fee' => 0, 'validity_period' => 'Forever', 'benefits' => 'Core workspace access'],
            ['name' => 'Silver', 'fee' => 199, 'validity_period' => '1 month', 'benefits' => 'Priority task support and expanded workspace tools'],
            ['name' => 'Gold', 'fee' => 499, 'validity_period' => '1 month', 'benefits' => 'Advanced tools, priority support, and member benefits'],
            ['name' => 'Platinum', 'fee' => 999, 'validity_period' => '1 month', 'benefits' => 'All features plus premium support'],
        ] as $level) {
            MembershipLevel::firstOrCreate(['name' => $level['name']], $level + ['is_active' => true]);
        }

        $this->call(AdminBootstrapSeeder::class);
    }
}
