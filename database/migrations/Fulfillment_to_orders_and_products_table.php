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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('courier_name')->nullable()->after('order_status');
            $table->string('tracking_number')->nullable()->after('courier_name');
            $table->timestamp('shipped_at')->nullable()->after('tracking_number');
            $table->timestamp('delivered_at')->nullable()->after('shipped_at');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->unsignedInteger('max_buyers_limit')->nullable()->after('group_size_required');
            $table->decimal('tier2_group_price', 10, 2)->nullable()->after('group_price');
            $table->decimal('tier3_group_price', 10, 2)->nullable()->after('tier2_group_price');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->text('shop_description')->nullable()->after('business_category');
            $table->string('shop_banner')->nullable()->after('shop_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['courier_name', 'tracking_number', 'shipped_at', 'delivered_at']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['max_buyers_limit', 'tier2_group_price', 'tier3_group_price']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['shop_description', 'shop_banner']);
        });
    }
};
