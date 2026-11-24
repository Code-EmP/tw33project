<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use RuntimeException;

class AdminBootstrapSeeder extends Seeder
{
    public function run(): void
    {
        $email = config('services.admin_bootstrap.email');
        $password = config('services.admin_bootstrap.password');

        if (blank($email) && blank($password)) {
            return;
        }

        if (! is_string($email) || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new RuntimeException('ADMIN_EMAIL must be a valid email address when bootstrapping an admin.');
        }

        if (! is_string($password) || strlen($password) < 12) {
            throw new RuntimeException('ADMIN_PASSWORD must contain at least 12 characters when bootstrapping an admin.');
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => config('services.admin_bootstrap.name', 'Workspace Admin'),
                'password' => $password,
                'role' => 'admin',
                'email_verified_at' => now(),
            ],
        );
    }
}
