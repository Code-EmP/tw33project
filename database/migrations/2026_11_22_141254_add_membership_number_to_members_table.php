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
        Schema::table('members', function (Blueprint $table) {
            $table->string('membership_number')->nullable()->unique()->after('id');
        });

        DB::table('members')->orderBy('id')->each(function (object $member): void {
            DB::table('members')->where('id', $member->id)->update([
                'membership_number' => 'MBR-'.str_pad((string) $member->id, 6, '0', STR_PAD_LEFT),
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropUnique(['membership_number']);
            $table->dropColumn('membership_number');
        });
    }
};
