<?php

namespace App\Domain\Inventory\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domain\Collections\Models\MaizeCollection;
use App\Domain\Production\Models\ProductionBatch;

class RawInventoryMovement extends Model
{
    use HasFactory;

    public const TYPE_IN = 'IN';
    public const TYPE_OUT = 'OUT';

    public const SOURCE_COLLECTION = 'collection';
    public const SOURCE_PRODUCTION = 'production';

    protected $fillable = [
        'type',
        'source',
        'quantity',
        'location_id',
        'reference_id',
        'movement_date',
    ];

    protected $casts = [
        'quantity' => 'decimal:3',
        'movement_date' => 'datetime',
    ];

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function collection(): BelongsTo
    {
        return $this->belongsTo(MaizeCollection::class, 'reference_id', 'id');
    }

    public function productionBatch(): BelongsTo
    {
        return $this->belongsTo(ProductionBatch::class, 'reference_id', 'id');
    }
}
