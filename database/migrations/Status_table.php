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
        Schema::table('users', function (Blueprint $table) {
            $table->string('status', 30)->default('active')->index()->after('role');
            $table->string('status_reason', 255)->nullable()->after('status');
        });

        // Set existing sellers to approved if they are sellers
        DB::table('users')->where('role', 'seller')->update(['status' => 'approved']);
        // Set all other users to active
        DB::table('users')->where('role', '!=', 'seller')->update(['status' => 'active']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['status', 'status_reason']);
        });
    }
};
