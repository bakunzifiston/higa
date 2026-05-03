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
        Schema::create('production_batches', function (Blueprint $table) {
            $table->id();
            $table->string('batch_number', 191)->unique();
            $table->foreignId('location_id')->constrained('locations')->restrictOnDelete();
            $table->decimal('maize_used', 14, 3);
            $table->decimal('quantity_produced', 14, 3);
            $table->decimal('wastage_quantity', 14, 3)->default(0);
            $table->decimal('quality_percentage', 5, 2);
            $table->date('production_date');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['location_id', 'production_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_batches');
    }
};
