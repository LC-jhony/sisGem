<?php

namespace App\Models;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
      protected $fillable = [
        'vehicle_id',
        'date',
        'name',
        'file',
    ];
        public function vehicle(): BelongsTo
    {
        return $this->belongsTo(
            related: Vehicle::class,
            foreignKey: 'vehicle_id',
        );
    }
}
