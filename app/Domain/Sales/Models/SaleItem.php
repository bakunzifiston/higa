<?php

namespace App\Domain\Sales\Models;

use App\Domain\Inventory\Models\Product;
use App\Domain\Inventory\Models\ProductPackage;
use App\Domain\Production\Models\ProductionBatch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SaleItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'product_id',
        'product_package_id',
        'production_batch_id',
        'quantity',
        'price',
        'line_total',
    ];

    protected $casts = [
        'quantity' => 'decimal:3',
        'price' => 'decimal:2',
        'line_total' => 'decimal:2',
    ];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(ProductPackage::class, 'product_package_id');
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(ProductionBatch::class, 'production_batch_id');
    }

    public function returns(): HasMany
    {
        return $this->hasMany(SaleReturn::class);
    }
}
