<?php

namespace App\Domain\Production\Services;

use App\Domain\Production\Models\BatchExpense;
use App\Domain\Production\Models\ProductionBatch;

class BatchExpenseService
{
    public function addExpense(array $data): BatchExpense
    {
        ProductionBatch::query()->findOrFail($data['production_batch_id']);

        return BatchExpense::query()->create([
            'production_batch_id' => $data['production_batch_id'],
            'type' => $data['type'],
            'amount' => $data['amount'],
            'description' => $data['description'] ?? null,
        ]);
    }
}
