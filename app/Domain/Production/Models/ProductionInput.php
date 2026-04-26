<?php

namespace App\Domain\Production\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductionInput extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_batch_id',
        'quantity',
        'unit',
    ];

    protected $casts = [
        'quantity' => 'decimal:3',
    ];

    public function batch(): BelongsTo
    {
        return $this->belongsTo(ProductionBatch::class, 'production_batch_id');
    }
}
