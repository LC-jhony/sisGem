<?php

use App\Livewire\MaintenanceVehicle;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(MaintenanceVehicle::class)
        ->assertStatus(200);
});
