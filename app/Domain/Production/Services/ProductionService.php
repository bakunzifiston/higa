<?php

namespace App\Domain\Production\Services;

use App\Domain\Inventory\Models\ProductPackage;
use App\Domain\Inventory\Services\FinishedInventoryService;
use App\Domain\Inventory\Services\RawInventoryService;
use App\Domain\Production\Models\ProductionBatch;
use App\Domain\Production\Models\ProductionInput;
use App\Domain\Production\Models\ProductionOutput;
use App\Domain\Production\Models\ProductionWastage;
use DomainException;
use Illuminate\Support\Facades\DB;

class ProductionService
{
    public function __construct(
        private readonly RawInventoryService $rawInventoryService,
        private readonly FinishedInventoryService $finishedInventoryService,
    ) {
    }

    public function createBatch(array $data): ProductionBatch
    {
        $maizeUsed = round((float) $data['maize_used'], 3);
        $produced = round((float) $data['quantity_produced'], 3);
        $wastage = round((float) $data['wastage_quantity'], 3);

        if (abs($maizeUsed - ($produced + $wastage)) > 0.001) {
            throw new DomainException('Invalid production balance: maize_used must equal quantity_produced + wastage_quantity.');
        }

        $outputsTotal = round(array_sum(array_map(static fn ($output) => (float) $output['quantity'], $data['outputs'])), 3);

        if (abs($outputsTotal - $produced) > 0.001) {
            throw new DomainException('Sum of production outputs must equal quantity_produced.');
        }

        foreach ($data['outputs'] as $output) {
            $package = ProductPackage::query()->findOrFail($output['product_package_id']);

            if ((int) $package->product_id !== (int) $output['product_id']) {
                throw new DomainException('Output package does not belong to selected product.');
            }
        }

        $this->rawInventoryService->assertSufficientStock((int) $data['location_id'], $maizeUsed);

        return DB::transaction(function () use ($data, $maizeUsed, $wastage) {
            $batch = ProductionBatch::query()->create([
                'batch_number' => $data['batch_number'],
                'location_id' => $data['location_id'],
                'maize_used' => $data['maize_used'],
                'quantity_produced' => $data['quantity_produced'],
                'wastage_quantity' => $data['wastage_quantity'],
                'quality_percentage' => $data['quality_percentage'],
                'production_date' => $data['production_date'],
                'notes' => $data['notes'] ?? null,
            ]);

            ProductionInput::query()->create([
                'production_batch_id' => $batch->id,
                'quantity' => $maizeUsed,
                'unit' => 'kg',
            ]);

            if ($wastage > 0) {
                ProductionWastage::query()->create([
                    'production_batch_id' => $batch->id,
                    'quantity' => $wastage,
                    'reason' => $data['wastage_reason'] ?? 'Process wastage',
                ]);
            }

            foreach ($data['outputs'] as $output) {
                $createdOutput = ProductionOutput::query()->create([
                    'production_batch_id' => $batch->id,
                    'product_id' => $output['product_id'],
                    'product_package_id' => $output['product_package_id'],
                    'quantity' => $output['quantity'],
                ]);

                $this->finishedInventoryService->moveInFromProduction(
                    batchId: (int) $batch->id,
                    productId: (int) $output['product_id'],
                    packageId: (int) $output['product_package_id'],
                    locationId: (int) $batch->location_id,
                    quantity: (float) $output['quantity'],
                    referenceId: (int) $createdOutput->id,
                    dateTime: $batch->production_date->toDateString() . ' 00:00:00',
                );
            }

            $this->rawInventoryService->moveOutToProduction(
                locationId: (int) $batch->location_id,
                batchId: (int) $batch->id,
                quantity: $maizeUsed,
                dateTime: $batch->production_date->toDateString() . ' 00:00:00',
            );

            return $batch->load(['inputs', 'outputs', 'wastage']);
        });
    }
}
