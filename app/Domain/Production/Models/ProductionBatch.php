<?php

namespace App\Domain\Production\Models;

use App\Domain\Inventory\Models\Location;
use App\Domain\Sales\Models\SaleItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductionBatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_number',
        'location_id',
        'maize_used',
        'quantity_produced',
        'wastage_quantity',
        'quality_percentage',
        'production_date',
        'notes',
    ];

    protected $casts = [
        'maize_used' => 'decimal:3',
        'quantity_produced' => 'decimal:3',
        'wastage_quantity' => 'decimal:3',
        'quality_percentage' => 'decimal:2',
        'production_date' => 'date',
    ];

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function inputs(): HasMany
    {
        return $this->hasMany(ProductionInput::class);
    }

    public function outputs(): HasMany
    {
        return $this->hasMany(ProductionOutput::class);
    }

    public function wastage(): HasMany
    {
        return $this->hasMany(ProductionWastage::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(BatchExpense::class);
    }

    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }
}
