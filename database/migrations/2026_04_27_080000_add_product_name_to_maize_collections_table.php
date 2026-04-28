<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('maize_collections', function (Blueprint $table) {
            $table->string('product_name')->nullable()->after('location_id');
        });
    }

    public function down(): void
    {
        Schema::table('maize_collections', function (Blueprint $table) {
            $table->dropColumn('product_name');
        });
    }
};

