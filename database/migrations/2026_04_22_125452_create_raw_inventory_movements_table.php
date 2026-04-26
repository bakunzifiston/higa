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
        Schema::create('raw_inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['IN', 'OUT']);
            $table->enum('source', ['collection', 'production']);
            $table->decimal('quantity', 14, 3);
            $table->foreignId('location_id')->constrained('locations')->restrictOnDelete();
            $table->unsignedBigInteger('reference_id');
            $table->timestamp('movement_date');
            $table->timestamps();

            $table->index(['location_id', 'type']);
            $table->index(['source', 'reference_id']);
            $table->index('movement_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raw_inventory_movements');
    }
};
