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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('sku')->unique()->nullable();
            $table->string('name');
            $table->json('attributes')->nullable(); // JSON: {'size': 'M', 'color': 'Red'}
            $table->boolean('is_default');
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('product_id');
            $table->index(['product_id', 'name']);
            $table->index(['attributes']);
            $table->index('created_at');
            $table->index('updated_at');
            $table->index('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
