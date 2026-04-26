<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Inventory\Models\FinishedInventoryMovement;
use App\Domain\Inventory\Services\FinishedInventoryService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FinishedInventoryController extends Controller
{
    public function __construct(private readonly FinishedInventoryService $finishedInventoryService)
    {
    }

    public function movements(Request $request)
    {
        $query = FinishedInventoryMovement::query()->latest('movement_date');

        foreach (['location_id', 'product_id', 'product_package_id'] as $field) {
            if ($request->filled($field)) {
                $query->where($field, $request->integer($field));
            }
        }

        return response()->json([
            'data' => $query->paginate(50),
        ]);
    }

    public function stock(Request $request)
    {
        $validated = $request->validate([
            'location_id' => ['required', 'integer', 'exists:locations,id'],
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'product_package_id' => ['required', 'integer', 'exists:product_packages,id'],
        ]);

        return response()->json([
            'data' => [
                'location_id' => (int) $validated['location_id'],
                'product_id' => (int) $validated['product_id'],
                'product_package_id' => (int) $validated['product_package_id'],
                'stock_quantity' => $this->finishedInventoryService->currentStock(
                    (int) $validated['location_id'],
                    (int) $validated['product_id'],
                    (int) $validated['product_package_id']
                ),
            ],
        ]);
    }
}
