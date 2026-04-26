<?php

namespace App\Domain\Inventory\Models;

use App\Domain\Production\Models\ProductionBatch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FinishedInventoryMovement extends Model
{
    use HasFactory;

    public const TYPE_IN = 'IN';
    public const TYPE_OUT = 'OUT';

    public const SOURCE_PRODUCTION = 'production';
    public const SOURCE_SALE = 'sale';
    public const SOURCE_RETURN = 'return';

    protected $fillable = [
        'type',
        'source',
        'production_batch_id',
        'product_id',
        'product_package_id',
        'location_id',
        'quantity',
        'reference_id',
        'movement_date',
    ];

    protected $casts = [
        'quantity' => 'decimal:3',
        'movement_date' => 'datetime',
    ];

    public function batch(): BelongsTo
    {
        return $this->belongsTo(ProductionBatch::class, 'production_batch_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(ProductPackage::class, 'product_package_id');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}
