<?php

namespace App\Domain\Suppliers\Models;

use App\Domain\Collections\Models\MaizeCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Farmer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'country',
        'province',
        'district',
        'sector',
        'cell',
        'village',
    ];

    public function collections(): HasMany
    {
        return $this->hasMany(MaizeCollection::class);
    }
}
