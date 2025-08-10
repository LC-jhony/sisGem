<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'placa',
        'marca',
        'unidad',
        'property_card',
        'status',
    ];

    public function maintenances(): HasMany
    {
        return $this->hasMany(Mantenance::class);
    }
}
