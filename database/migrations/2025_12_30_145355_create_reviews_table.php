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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->nullOnDelete();
            $table->integer('rating');
            $table->text('content');
            $table->boolean('is_approved')->default(false); // Moderation queue
            $table->json('metadata')->nullable(); // Extra data: {'verified_purchase': true}

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index(['product_id', 'is_approved']);
            $table->index(['product_id', 'rating']);
            $table->index('created_at');
            $table->index('rating');
            $table->index('is_approved');

            // Unique constraint: prevent duplicate reviews from same user
            $table->unique(['product_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
