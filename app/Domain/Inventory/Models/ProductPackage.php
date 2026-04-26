<?php

namespace App\Domain\Inventory\Models;

use App\Domain\Production\Models\ProductionOutput;
use App\Domain\Sales\Models\SaleItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'weight_kg',
        'is_active',
    ];

    protected $casts = [
        'weight_kg' => 'decimal:3',
        'is_active' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function outputs(): HasMany
    {
        return $this->hasMany(ProductionOutput::class);
    }

    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }
}
