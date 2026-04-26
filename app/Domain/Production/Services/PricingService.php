<?php

namespace App\Domain\Production\Services;

use App\Domain\Inventory\Services\RawInventoryService;
use App\Domain\Production\Models\ProductionBatch;

class PricingService
{
    public function __construct(private readonly RawInventoryService $rawInventoryService)
    {
    }

    public function batchCostBreakdown(ProductionBatch $batch): array
    {
        $rawUnitCost = $this->rawInventoryService->averageRawMaterialCostPerKg((int) $batch->location_id);
        $rawMaterialCost = round($rawUnitCost * (float) $batch->maize_used, 2);

        $expenseCost = round((float) $batch->expenses()->sum('amount'), 2);
        $totalCost = round($rawMaterialCost + $expenseCost, 2);

        $produced = (float) $batch->quantity_produced;
        $costPerKg = $produced > 0 ? round($totalCost / $produced, 4) : 0.0;

        return [
            'raw_material_cost' => $rawMaterialCost,
            'expenses_cost' => $expenseCost,
            'total_cost' => $totalCost,
            'cost_per_kg' => $costPerKg,
            'suggested_selling_price_per_kg' => round($costPerKg * 1.2, 4),
        ];
    }
}
