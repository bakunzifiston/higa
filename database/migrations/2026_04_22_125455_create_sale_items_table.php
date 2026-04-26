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
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained('sales')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->restrictOnDelete();
            $table->foreignId('product_package_id')->constrained('product_packages')->restrictOnDelete();
            $table->foreignId('production_batch_id')->nullable()->constrained('production_batches')->nullOnDelete();
            $table->decimal('quantity', 14, 3);
            $table->decimal('price', 14, 2);
            $table->decimal('line_total', 14, 2);
            $table->timestamps();

            $table->index(['product_id', 'product_package_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_items');
    }
};
