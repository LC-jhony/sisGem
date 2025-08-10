<?php

namespace Database\Factories;

use App\Models\MaintenanceItem;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mantenance>
 */
class MantenanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $materialCost = $this->faker->randomFloat(2, 50, 500);
        $laborCost = $this->faker->randomFloat(2, 50, 500);
        $totalCost = $materialCost + $laborCost;

        return [
            'vehicle_id' => Vehicle::inRandomOrder()->first()->id,
            'maintenance_item_id' => MaintenanceItem::inRandomOrder()->first()->id,
            'mileage' => $this->faker->numberBetween(0, 300000),
            'is_done' => $this->faker->boolean(),
            'material_cost' => $materialCost,
            'labor_cost' => $laborCost,
            'total_cost' => $totalCost,
            'photo_path' => $this->faker->imageUrl(800, 600, 'vehicles', true),
            'file_path' => $this->faker->filePath(),
            'front_left_brake_pad' => $this->faker->numberBetween(0, 100), // en %
            'front_right_brake_pad' => $this->faker->numberBetween(0, 100),
            'rear_left_brake_pad' => $this->faker->numberBetween(0, 100),
            'rear_right_brake_pad' => $this->faker->numberBetween(0, 100),
            'brake_pads_checked_at' => $this->faker->optional()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
