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
        // 1. Column additions for products
        Schema::table('products', function (Blueprint $table) {
            $table->string('approval_status', 30)->default('approved')->index()->after('is_active');
            $table->boolean('is_featured')->default(false)->after('approval_status');
            $table->boolean('is_hot_deal')->default(false)->after('is_featured');
            $table->boolean('is_flash_sale')->default(false)->after('is_hot_deal');
        });

        // 2. Column additions for orders
        Schema::table('orders', function (Blueprint $table) {
            $table->string('escrow_status', 30)->default('held')->index()->after('payment_status');
        });

        // 3. Column additions for categories
        Schema::table('categories', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('description');
            $table->integer('sort_order')->default(0)->after('is_active');
        });

        // 4. Refund Requests table (ix)
        Schema::create('refund_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->string('type', 30)->default('group_failed');
            $table->string('reason', 255);
            $table->string('status', 30)->default('pending')->index();
            $table->string('payout_method', 50)->default('bKash');
            $table->string('payout_account', 100)->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });

        // 5. Reported Issues / Disputes table (x)
        Schema::create('reported_issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('seller_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('order_id')->nullable()->constrained('orders')->nullOnDelete();
            $table->string('ticket_number', 50)->unique();
            $table->string('subject', 255);
            $table->text('description');
            $table->string('issue_type', 50)->default('customer_complaint');
            $table->string('priority', 20)->default('medium');
            $table->string('status', 30)->default('open')->index();
            $table->text('admin_response')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });

        // 6. Platform Announcements & Notifications table (xii)
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('message');
            $table->string('type', 30)->default('banner_top');
            $table->string('target_audience', 30)->default('all');
            $table->string('action_url')->nullable();
            $table->string('action_label')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // 7. Audit Trail Activity Logs table (xiii)
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action');
            $table->text('description');
            $table->string('ip_address', 45)->nullable();
            $table->string('entity_type', 100)->nullable();
            $table->unsignedBigInteger('entity_id')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('announcements');
        Schema::dropIfExists('reported_issues');
        Schema::dropIfExists('refund_requests');

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['is_active', 'sort_order']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['escrow_status']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['approval_status', 'is_featured', 'is_hot_deal', 'is_flash_sale']);
        });
    }
};
