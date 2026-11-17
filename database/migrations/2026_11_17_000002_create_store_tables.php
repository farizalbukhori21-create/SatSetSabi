<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); $table->string('name'); $table->string('slug')->unique();
            $table->text('description')->nullable(); $table->boolean('is_active')->default(true); $table->timestamps();
        });
        Schema::create('products', function (Blueprint $table) {
            $table->id(); $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->string('name'); $table->string('slug')->unique(); $table->text('description')->nullable();
            $table->string('image')->nullable(); $table->boolean('is_active')->default(true); $table->timestamps();
        });
        Schema::create('denominations', function (Blueprint $table) {
            $table->id(); $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('name'); $table->unsignedBigInteger('price'); $table->boolean('is_active')->default(true); $table->timestamps();
        });
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->foreignId('denomination_id')->constrained()->restrictOnDelete();
            $table->string('order_code')->unique(); $table->string('player_id'); $table->string('server_id')->nullable();
            $table->string('customer_note', 500)->nullable(); $table->unsignedBigInteger('amount');
            $table->string('payment_method'); $table->string('payment_status')->default('unpaid')->index();
            $table->string('order_status')->default('pending_payment')->index(); $table->string('payment_proof')->nullable();
            $table->timestamp('paid_at')->nullable(); $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('orders'); Schema::dropIfExists('denominations');
        Schema::dropIfExists('products'); Schema::dropIfExists('categories');
    }
};
