<?php

namespace App\Domain\Collections\Models;

use App\Domain\Inventory\Models\Location;
use App\Domain\Suppliers\Models\Farmer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaizeCollection extends Model
{
    use HasFactory;

    protected $fillable = [
        'farmer_id',
        'location_id',
        'product_name',
        'collection_date',
        'quantity_collected',
        'quantity_rejected',
        'accepted_quantity',
        'price_per_kg',
        'rejection_reason',
        'notes',
    ];


    protected $casts = [
        'collection_date' => 'date',
        'quantity_collected' => 'decimal:3',
        'quantity_rejected' => 'decimal:3',
        'accepted_quantity' => 'decimal:3',
        'price_per_kg' => 'decimal:2',
    ];

    public function farmer(): BelongsTo
    {
        return $this->belongsTo(Farmer::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}
