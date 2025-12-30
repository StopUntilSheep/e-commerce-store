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
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();

            // Storage paths (required for file operations)
            $table->string('path');                         // Original image path
            $table->string('thumbnail_path')->nullable();   // Thumbnail storage path
            
            // Public URLs (required for frontend display)
            $table->string('url');                          // Original image URL
            $table->string('thumbnail_url')->nullable();    // Thumbnail URL
            
            // Display properties
            $table->string('alt_text')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->integer('order')->default(0);

            $table->timestamps();
            $table->softDeletes();
        
            // Indexes
            $table->index(['product_id', 'is_primary']);
            $table->index(['product_id', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
