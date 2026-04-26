<?php

namespace App\Domain\Reporting\Services;

use App\Domain\Collections\Models\MaizeCollection;
use App\Domain\Inventory\Models\FinishedInventoryMovement;
use App\Domain\Inventory\Models\RawInventoryMovement;
use App\Domain\Production\Models\ProductionBatch;
use App\Domain\Sales\Models\Sale;

class DashboardService
{
    public function build(): array
    {
        $rawStock = RawInventoryMovement::query()
            ->selectRaw("location_id, SUM(CASE WHEN type='IN' THEN quantity ELSE -quantity END) as quantity")
            ->groupBy('location_id')
            ->get();

        $finishedStock = FinishedInventoryMovement::query()
            ->selectRaw("location_id, product_id, product_package_id, SUM(CASE WHEN type='IN' THEN quantity ELSE -quantity END) as quantity")
            ->groupBy('location_id', 'product_id', 'product_package_id')
            ->get();

        $production = ProductionBatch::query()
            ->selectRaw('COUNT(*) as batches, SUM(maize_used) as maize_used, SUM(quantity_produced) as produced, SUM(wastage_quantity) as wastage')
            ->first();

        $salesTrend = Sale::query()
            ->selectRaw('sale_date, SUM(total_amount) as total_sales')
            ->groupBy('sale_date')
            ->orderBy('sale_date')
            ->limit(30)
            ->get();

        $supplierPerformance = MaizeCollection::query()
            ->selectRaw('farmer_id, SUM(accepted_quantity) as total_accepted, SUM(quantity_rejected) as total_rejected')
            ->groupBy('farmer_id')
            ->orderByDesc('total_accepted')
            ->limit(10)
            ->get();

        $efficiency = 0;
        $wastagePercent = 0;
        if ($production && (float) $production->maize_used > 0) {
            $efficiency = round(((float) $production->produced / (float) $production->maize_used) * 100, 2);
            $wastagePercent = round(((float) $production->wastage / (float) $production->maize_used) * 100, 2);
        }

        return [
            'stock_levels' => [
                'raw' => $rawStock,
                'finished' => $finishedStock,
            ],
            'production_efficiency_percentage' => $efficiency,
            'wastage_percentage' => $wastagePercent,
            'sales_trends' => $salesTrend,
            'supplier_performance' => $supplierPerformance,
        ];
    }
}
