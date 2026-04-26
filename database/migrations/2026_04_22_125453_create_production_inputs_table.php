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
        Schema::create('production_inputs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_batch_id')->constrained('production_batches')->cascadeOnDelete();
            $table->decimal('quantity', 14, 3);
            $table->string('unit')->default('kg');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_inputs');
    }
};
