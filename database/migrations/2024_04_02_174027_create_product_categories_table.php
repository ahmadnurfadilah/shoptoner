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
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable();
            $table->foreignId('store_id')->constrained('stores')->cascadeOnDelete();
            $table->string('slug');
            $table->string('name');
            $table->string('description')->nullable();
            $table->boolean('is_active')->default(1);
            $table->integer('order_column');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['store_id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_categories');
    }
};
