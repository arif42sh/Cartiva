<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedInteger('min_quota_to_ship')->nullable()->after('group_size_required');
        });

        Schema::table('group_buy_sessions', function (Blueprint $table) {
            $table->unsignedInteger('min_quota_to_ship')->nullable()->after('required_members');
            $table->unsignedInteger('max_buyers_limit')->nullable()->after('min_quota_to_ship');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('group_buy_sessions', function (Blueprint $table) {
            $table->dropColumn(['min_quota_to_ship', 'max_buyers_limit']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['min_quota_to_ship']);
        });
    }
};
