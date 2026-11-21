<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->longText('image_url');
            $table->json('gallery')->nullable();
            $table->decimal('single_price', 10, 2);
            $table->decimal('group_price', 10, 2);
            $table->unsignedInteger('group_size_required')->default(2);
            $table->unsignedInteger('group_duration_hours')->default(24);
            $table->unsignedInteger('stock')->default(50);
            $table->boolean('is_active')->default(true);
            $table->decimal('rating', 3, 2)->default(4.8);
            $table->unsignedInteger('sales_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
