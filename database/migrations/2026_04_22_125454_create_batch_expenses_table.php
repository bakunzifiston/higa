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
        Schema::create('batch_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_batch_id')->constrained('production_batches')->cascadeOnDelete();
            $table->enum('type', ['labor', 'transport', 'packaging', 'utilities']);
            $table->decimal('amount', 14, 2);
            $table->string('description')->nullable();
            $table->timestamps();

            $table->index(['production_batch_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batch_expenses');
    }
};
