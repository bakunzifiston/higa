<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Production\Models\BatchExpense;
use App\Domain\Production\Services\BatchExpenseService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreBatchExpenseRequest;
use Illuminate\Http\Request;

class BatchExpenseController extends Controller
{
    public function __construct(private readonly BatchExpenseService $batchExpenseService)
    {
    }

    public function store(StoreBatchExpenseRequest $request)
    {
        $expense = $this->batchExpenseService->addExpense($request->validated());

        return response()->json(['data' => $expense], 201);
    }

    public function index(Request $request)
    {
        $query = BatchExpense::query()->latest();

        if ($request->filled('production_batch_id')) {
            $query->where('production_batch_id', $request->integer('production_batch_id'));
        }

        return response()->json(['data' => $query->paginate(50)]);
    }
}
