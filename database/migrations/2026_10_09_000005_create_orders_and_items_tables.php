<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('order_number', 40)->unique();
            $table->enum('order_type', ['single', 'group_buy'])->default('single');
            $table->foreignId('group_buy_session_id')->nullable()->constrained('group_buy_sessions')->nullOnDelete();
            $table->decimal('total_amount', 10, 2);
            $table->string('payment_method')->default('Cash on Delivery');
            $table->enum('payment_status', ['paid', 'pending', 'refunded'])->default('paid');
            $table->enum('order_status', ['pending_group', 'processing', 'shipped', 'delivered', 'cancelled', 'refunded'])->default('processing');
            $table->string('shipping_name');
            $table->string('shipping_phone');
            $table->text('shipping_address');
            $table->text('order_notes')->nullable();
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('unit_price', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
