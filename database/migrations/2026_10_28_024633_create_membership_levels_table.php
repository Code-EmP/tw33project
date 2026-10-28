<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('membership_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->decimal('fee', 10, 2)->default(0);
            $table->string('validity_period');
            $table->text('benefits')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        DB::table('membership_levels')->insert([
            ['name' => 'Basic', 'fee' => 0, 'validity_period' => '1 month', 'benefits' => 'Standard membership access', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Silver', 'fee' => 500, 'validity_period' => '6 months', 'benefits' => 'Extended access and member discounts', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Gold', 'fee' => 900, 'validity_period' => '1 year', 'benefits' => 'Priority access and exclusive benefits', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Platinum', 'fee' => 1500, 'validity_period' => '1 year', 'benefits' => 'All premium benefits and priority support', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_levels');
    }
};
