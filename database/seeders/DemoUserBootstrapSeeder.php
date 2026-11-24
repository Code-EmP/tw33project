<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\MembershipCategory;
use App\Models\MembershipLevel;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoUserBootstrapSeeder extends Seeder
{
    public function run(): void
    {
        $configuredEmail = config('services.demo_user.email');
        $password = config('services.demo_user.password');

        if (blank($configuredEmail) && blank($password)) {
            return;
        }

        if (! is_string($configuredEmail) || ! filter_var($configuredEmail, FILTER_VALIDATE_EMAIL)
            || ! is_string($password) || strlen($password) < 12) {
            logger()->warning('Demo member bootstrap skipped. Configure a valid DEMO_USER_EMAIL and a DEMO_USER_PASSWORD of at least 12 characters.');

            return;
        }

        $email = mb_strtolower(trim($configuredEmail));
        $user = User::query()->whereRaw('LOWER(email) = ?', [$email])->first();

        if ($user?->isAdmin()) {
            logger()->warning('Demo member bootstrap skipped because DEMO_USER_EMAIL belongs to an admin account.');

            return;
        }

        $user ??= new User;
        $user->forceFill([
            'name' => config('services.demo_user.name', 'Demo Member'),
            'email' => $email,
            'password' => $password,
            'role' => 'member',
            'email_verified_at' => $user->email_verified_at ?? now(),
        ]);
        $user->save();

        $member = Member::query()->whereRaw('LOWER(email) = ?', [$email])->first();

        if ($member !== null) {
            $member->update(['name' => $user->name]);

            return;
        }

        $category = MembershipCategory::firstOrCreate(
            ['name' => 'General'],
            ['description' => 'Default member category', 'is_active' => true],
        );
        $level = MembershipLevel::firstOrCreate(
            ['name' => 'Basic'],
            ['fee' => 0, 'validity_period' => 'Forever', 'benefits' => 'Access to the core workspace', 'is_active' => true],
        );

        Member::create([
            'name' => $user->name,
            'email' => $email,
            'category' => $category->name,
            'level' => $level->name,
            'membership_category_id' => $category->id,
            'membership_level_id' => $level->id,
        ]);
    }
}
