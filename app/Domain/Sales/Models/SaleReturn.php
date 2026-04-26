<?php

namespace App\Domain\Sales\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleReturn extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'sale_item_id',
        'quantity',
        'reason',
        'refund_status',
        'refund_amount',
        'return_date',
    ];

    protected $casts = [
        'quantity' => 'decimal:3',
        'refund_amount' => 'decimal:2',
        'return_date' => 'date',
    ];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function saleItem(): BelongsTo
    {
        return $this->belongsTo(SaleItem::class);
    }
}
