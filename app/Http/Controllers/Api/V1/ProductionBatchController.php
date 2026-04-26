<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Production\Models\ProductionBatch;
use App\Domain\Production\Services\PricingService;
use App\Domain\Production\Services\ProductionService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreProductionBatchRequest;
use App\Http\Resources\V1\ProductionBatchResource;

class ProductionBatchController extends Controller
{
    public function __construct(
        private readonly ProductionService $productionService,
        private readonly PricingService $pricingService,
    ) {
    }

    public function index()
    {
        $batches = ProductionBatch::query()->with(['outputs', 'expenses'])->latest('production_date')->paginate(20);

        return ProductionBatchResource::collection($batches);
    }

    public function store(StoreProductionBatchRequest $request): ProductionBatchResource
    {
        $batch = $this->productionService->createBatch($request->validated());

        return new ProductionBatchResource($batch->load(['inputs', 'outputs', 'wastage', 'expenses']));
    }

    public function show(ProductionBatch $batch)
    {
        $batch->load(['inputs', 'outputs', 'wastage', 'expenses']);
        $pricing = $this->pricingService->batchCostBreakdown($batch);

        return response()->json([
            'data' => new ProductionBatchResource($batch),
            'pricing' => $pricing,
        ]);
    }
}
