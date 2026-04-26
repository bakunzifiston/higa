<?php

namespace App\Domain\Production\Models;

use App\Domain\Inventory\Models\Product;
use App\Domain\Inventory\Models\ProductPackage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductionOutput extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_batch_id',
        'product_id',
        'product_package_id',
        'quantity',
    ];

    protected $casts = [
        'quantity' => 'decimal:3',
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
}
