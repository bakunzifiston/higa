<?php

namespace App\Domain\Sales\Models;

use App\Domain\Finance\Models\Payment;
use App\Domain\Inventory\Models\Location;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'customer_name',
        'customer_phone',
        'customer_address',
        'location_id',
        'payment_method',
        'delivery_status',
        'total_amount',
        'sale_date',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'sale_date' => 'date',
    ];

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    public function returns(): HasMany
    {
        return $this->hasMany(SaleReturn::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
