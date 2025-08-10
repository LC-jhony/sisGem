<?php

namespace App\Models;

use App\Models\Vehicle;
use App\Models\MaintenanceItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Testing\Fluent\Concerns\Has;

class Mantenance extends Model
{
    use HasFactory;
    protected $table = 'maintenances';

    protected $fillable = [
        'vehicle_id',
        'maintenance_item_id',
        'mileage',
        'is_done',
        'material_cost',
        'labor_cost',
        'total_cost',
        'photo_path',
        'file_path',
        'front_left_brake_pad',
        'front_right_brake_pad',
        'rear_left_brake_pad',
        'rear_right_brake_pad',
        'brake_pads_checked_at',
    ];
    protected $casts = [
        'material_cost' => 'decimal:2',
        'labor_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'brake_pads_checked_at' => 'datetime',
    ];
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(
            related: Vehicle::class,
            foreignKey: 'vehicle_id',
        );
    }

    public function maintenanceItem(): BelongsTo
    {
        return $this->belongsTo(
            related: MaintenanceItem::class,
            foreignKey: 'maintenance_item_id',
        );
    }
}
