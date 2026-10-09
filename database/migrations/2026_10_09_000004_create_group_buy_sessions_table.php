<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('group_buy_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('leader_user_id')->constrained('users')->cascadeOnDelete();
            $table->string('group_code', 30)->unique();
            $table->unsignedInteger('required_members')->default(2);
            $table->unsignedInteger('current_members')->default(1);
            $table->enum('status', ['active', 'completed', 'expired'])->default('active');
            $table->timestamp('expires_at');
            $table->timestamps();
        });

        Schema::create('group_buy_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_buy_session_id')->constrained('group_buy_sessions')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->boolean('is_leader')->default(false);
            $table->timestamp('joined_at')->useCurrent();
            $table->timestamps();

            $table->unique(['group_buy_session_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_buy_members');
        Schema::dropIfExists('group_buy_sessions');
    }
};
