<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'code' => strtoupper($this->faker->bothify('VEH-###??')),
            'placa' => strtoupper($this->faker->bothify('???-####')),
            'marca' => $this->faker->randomElement(['Toyota', 'Nissan', 'Ford', 'Chevrolet', 'Hyundai', 'Kia']),
            'unidad' => $this->faker->word(),
            'property_card' => $this->faker->year(),
            'status' => $this->faker->randomElement(['Operativo', 'Fuera de Servicio', 'En Reparación']),
        ];
    }
}
