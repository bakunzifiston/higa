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
        Schema::create('sale_returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained('sales')->cascadeOnDelete();
            $table->foreignId('sale_item_id')->constrained('sale_items')->cascadeOnDelete();
            $table->decimal('quantity', 14, 3);
            $table->string('reason');
            $table->enum('refund_status', ['pending', 'partially_refunded', 'refunded'])->default('pending');
            $table->decimal('refund_amount', 14, 2)->default(0);
            $table->date('return_date');
            $table->timestamps();

            $table->index(['sale_id', 'return_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_returns');
    }
};
