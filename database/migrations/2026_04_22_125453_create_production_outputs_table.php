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
        Schema::create('production_outputs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_batch_id')->constrained('production_batches')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->restrictOnDelete();
            $table->foreignId('product_package_id')->constrained('product_packages')->restrictOnDelete();
            $table->decimal('quantity', 14, 3);
            $table->timestamps();

            $table->index(['product_id', 'product_package_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_outputs');
    }
};
