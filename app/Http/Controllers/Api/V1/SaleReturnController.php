<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Sales\Models\SaleReturn;
use App\Domain\Sales\Services\SalesReturnService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreSaleReturnRequest;
use App\Http\Resources\V1\SaleReturnResource;
use Illuminate\Http\Request;

class SaleReturnController extends Controller
{
    public function __construct(private readonly SalesReturnService $salesReturnService)
    {
    }

    public function store(StoreSaleReturnRequest $request): SaleReturnResource
    {
        $return = $this->salesReturnService->processReturn($request->validated());

        return new SaleReturnResource($return);
    }

    public function index(Request $request)
    {
        $query = SaleReturn::query()->latest('return_date');

        if ($request->filled('sale_id')) {
            $query->where('sale_id', $request->integer('sale_id'));
        }

        return SaleReturnResource::collection($query->paginate(50));
    }
}
