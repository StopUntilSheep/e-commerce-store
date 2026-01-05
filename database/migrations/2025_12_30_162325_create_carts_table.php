<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            
            // User association (nullable for guest carts)
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete();
            
            // Session ID for guest carts (when user_id is null)
            $table->string('session_id')->nullable();
            
            // Product reference
            $table->foreignId('product_id')
                  ->constrained()
                  ->cascadeOnDelete();
            
            // Variant information
            $table->string('product_variant_id')->nullable(); // If product has variants
            
            // Cart item details
            $table->integer('quantity')->default(1);
            $table->decimal('price_snapshot', 10, 2)->nullable(); // Price at time of adding
            
            // Timestamps for cart expiration
            $table->timestamps();
            $table->timestamp('expires_at')->nullable(); // Auto-cleanup old carts
            
            // ========== INDEXES ==========
            
            // For user cart queries
            $table->index('user_id');
            
            // For guest cart queries
            $table->index('session_id');
            
            // For finding specific product in cart
            $table->index(['user_id', 'product_id', 'variant_sku']);
            $table->index(['session_id', 'product_id', 'variant_sku']);
            
            // For cart cleanup (expired carts)
            $table->index('expires_at');
            
            // For product queries (which carts contain this product)
            $table->index('product_id');
            
            // Ensure uniqueness - prevent duplicate items in cart
            // Note: Using unique constraint requires careful handling of nulls
            $table->unique(['user_id', 'product_id', 'variant_sku'], 'cart_user_product_unique');
            $table->unique(['session_id', 'product_id', 'variant_sku'], 'cart_session_product_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};