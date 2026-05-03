<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('raw_inventory_movements', function (Blueprint $table) {
            $table->foreignId('maize_collection_id')->nullable()->after('location_id')->constrained('maize_collections')->nullOnDelete();
            $table->foreignId('production_batch_id')->nullable()->after('maize_collection_id')->constrained('production_batches')->nullOnDelete();
        });

        DB::table('raw_inventory_movements')->where('source', 'collection')->update([
            'maize_collection_id' => DB::raw('reference_id'),
        ]);
        DB::table('raw_inventory_movements')->where('source', 'production')->where('type', 'OUT')->update([
            'production_batch_id' => DB::raw('reference_id'),
        ]);

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
        });

        Schema::table('raw_inventory_movements', function (Blueprint $table) {
            $table->dropForeign(['maize_collection_id']);
            $table->dropForeign(['production_batch_id']);
        });
    }
};
