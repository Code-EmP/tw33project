<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // The default Laravel users migration already creates the sessions table.
    }

    public function down(): void
    {
        // Keep the sessions table owned by the default Laravel users migration.
    }
};
