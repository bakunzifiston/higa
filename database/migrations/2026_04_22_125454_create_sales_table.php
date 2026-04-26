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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->string('customer_name');
            $table->string('customer_phone')->nullable();
            $table->text('customer_address')->nullable();
            $table->foreignId('location_id')->constrained('locations')->restrictOnDelete();
            $table->enum('payment_method', ['cash', 'mobile_money', 'bank_transfer', 'credit']);
            $table->enum('delivery_status', ['pending', 'in_transit', 'delivered'])->default('pending');
            $table->decimal('total_amount', 14, 2)->default(0);
            $table->date('sale_date');
            $table->timestamps();

            $table->index(['location_id', 'sale_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
