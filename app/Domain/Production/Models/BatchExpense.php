<?php

namespace App\Domain\Production\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BatchExpense extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_batch_id',
        'type',
        'amount',
        'description',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function batch(): BelongsTo
    {
        return $this->belongsTo(ProductionBatch::class, 'production_batch_id');
    }
}
