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
        Schema::create('maize_collections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farmer_id')->constrained('farmers')->cascadeOnDelete();
            $table->foreignId('location_id')->constrained('locations')->restrictOnDelete();
            $table->date('collection_date');
            $table->decimal('quantity_collected', 14, 3);
            $table->decimal('quantity_rejected', 14, 3)->default(0);
            $table->decimal('accepted_quantity', 14, 3);
            $table->decimal('price_per_kg', 14, 2);
            $table->text('rejection_reason')->nullable();
            $table->timestamps();

            $table->index(['farmer_id', 'collection_date']);
            $table->index(['location_id', 'collection_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maize_collections');
    }
};
