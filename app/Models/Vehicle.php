<?php

namespace App\Models;

use App\Models\Document;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
 public function documents(): HasMany
    {
        return $this->hasMany(
            related: Document::class,
            foreignKey: 'vehicle_id',
        );
    }
    public function maintenances(): HasMany
    {
        return $this->hasMany(Mantenance::class);
    }
}
