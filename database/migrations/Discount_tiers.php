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
            $table->json('discount_tiers')->nullable()->after('group_size_required');
        });

        Schema::table('group_buy_sessions', function (Blueprint $table) {
            $table->json('discount_tiers')->nullable()->after('required_members');
            $table->unsignedInteger('achieved_tier_members')->nullable()->after('discount_tiers');
            $table->decimal('achieved_discount_percent', 5, 2)->nullable()->after('achieved_tier_members');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('group_buy_sessions', function (Blueprint $table) {
            $table->dropColumn(['discount_tiers', 'achieved_tier_members', 'achieved_discount_percent']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['discount_tiers']);
        });
    }
};
