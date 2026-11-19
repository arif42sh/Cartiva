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
        Schema::table('users', function (Blueprint $table) {
            $table->string('shop_slug')->nullable()->after('shop_name');
            $table->string('whatsapp_number')->nullable()->after('phone');
            $table->string('facebook_page')->nullable()->after('whatsapp_number');
            $table->string('dispatch_time')->nullable()->after('shop_description');
            $table->text('return_policy')->nullable()->after('dispatch_time');
            $table->text('warehouse_address')->nullable()->after('address');
            $table->string('payout_method')->nullable()->after('warehouse_address');
            $table->text('payout_details')->nullable()->after('payout_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'shop_slug',
                'whatsapp_number',
                'facebook_page',
                'dispatch_time',
                'return_policy',
                'warehouse_address',
                'payout_method',
                'payout_details',
            ]);
        });
    }
};
