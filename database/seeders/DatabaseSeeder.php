<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\MaintenanceItem;
use App\Models\Mantenance;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $items = [
            ['name' => 'FILTRO DE ACEITE DE MOTOR'],
            ['name' => 'FILTRO DE COMBUSTIBLE'],
            ['name' => 'FILTRO DE AIRE'],
            ['name' => 'FILTRO P/POLVO A/C'],
            ['name' => 'FILTRO TAMIZ'],
            ['name' => 'ANILLO TAPON DE CARTER'],
            ['name' => 'ACEITE SINTETICO - MOTOR'],
            ['name' => 'ACEITE DE CAJA DE CAMBIOS'],
            ['name' => 'ACEITE DIFERENCIAL'],
            ['name' => 'ACEITE DE DIRECCION ATF'],
            ['name' => 'LIQUIDO REFRIG. PARA MOTOR'],
            ['name' => 'LIQUIDO PARA FRENOS/EMBRIAGUE'],
            ['name' => 'CONCENTRADO LAVACRISTALES'],
        ];

        foreach ($items as $item) {
            MaintenanceItem::create($item);
        }
        Vehicle::factory(1000)->create();
        Mantenance::factory(100000)->create();
    }

}
