<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Inventory\Models\RawInventoryMovement;
use App\Domain\Inventory\Services\RawInventoryService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RawInventoryController extends Controller
{
    public function __construct(private readonly RawInventoryService $rawInventoryService)
    {
    }

    public function movements(Request $request)
    {
        $query = RawInventoryMovement::query()->latest('movement_date');

        if ($request->filled('location_id')) {
            $query->where('location_id', $request->integer('location_id'));
        }

        return response()->json([
            'data' => $query->paginate(50),
        ]);
    }

    public function stockByLocation(int $location)
    {
        return response()->json([
            'data' => [
                'location_id' => $location,
                'stock_kg' => $this->rawInventoryService->currentStockByLocation($location),
            ],
        ]);
    }
}
