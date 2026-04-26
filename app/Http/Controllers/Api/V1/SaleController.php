<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Sales\Models\Sale;
use App\Domain\Sales\Services\SalesService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreSaleRequest;
use App\Http\Resources\V1\SaleResource;

class SaleController extends Controller
{
    public function __construct(private readonly SalesService $salesService)
    {
    }

    public function index()
    {
        $sales = Sale::query()->with(['items', 'payments'])->latest('sale_date')->paginate(20);

        return SaleResource::collection($sales);
    }

    public function store(StoreSaleRequest $request): SaleResource
    {
        $sale = $this->salesService->createSale($request->validated());

        return new SaleResource($sale->load(['items', 'payments', 'returns']));
    }

    public function show(Sale $sale): SaleResource
    {
        return new SaleResource($sale->load(['items', 'payments', 'returns']));
    }
}
