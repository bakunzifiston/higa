<?php

namespace App\Domain\Inventory\Models;

use App\Domain\Production\Models\ProductionOutput;
use App\Domain\Sales\Models\SaleItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'description',
        'classification',
        'cost_price',
        'selling_price',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'cost_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
    ];

    public function packages(): HasMany
    {
        return $this->hasMany(ProductPackage::class);
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
