<?php

namespace App\Domain\Inventory\Models;

use App\Domain\Collections\Models\MaizeCollection;
use App\Domain\Production\Models\ProductionBatch;
use App\Domain\Sales\Models\Sale;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'country',
        'province',
        'district',
        'sector',
        'cell',
        'village',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function collections(): HasMany
    {
        return $this->hasMany(MaizeCollection::class);
    }

    public function rawInventoryMovements(): HasMany
    {
        return $this->hasMany(RawInventoryMovement::class);
    }

    public function finishedInventoryMovements(): HasMany
    {
        return $this->hasMany(FinishedInventoryMovement::class);
    }

    public function productionBatches(): HasMany
    {
        return $this->hasMany(ProductionBatch::class);
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }
}
