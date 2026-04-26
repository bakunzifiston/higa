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
        Schema::create('finished_inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['IN', 'OUT']);
            $table->enum('source', ['production', 'sale', 'return']);
            $table->foreignId('production_batch_id')->nullable()->constrained('production_batches')->nullOnDelete();
            $table->foreignId('product_id')->constrained('products')->restrictOnDelete();
            $table->foreignId('product_package_id')->constrained('product_packages')->restrictOnDelete();
            $table->foreignId('location_id')->constrained('locations')->restrictOnDelete();
            $table->decimal('quantity', 14, 3);
            $table->unsignedBigInteger('reference_id');
            $table->timestamp('movement_date');
            $table->timestamps();

            $table->index(['location_id', 'product_id', 'product_package_id'], 'fim_loc_prod_pkg_idx');
            $table->index(['source', 'reference_id'], 'fim_source_ref_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finished_inventory_movements');
    }
};
