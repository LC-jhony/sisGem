<?php

use App\Http\Controllers\PrinMaintenanceController;
use App\Http\Controllers\ValueMaintenanceController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('value-maintenance-vehicle/{id}', ValueMaintenanceController::class)
    ->name('valuemantenacevehicle');
Route::get('/print-maintenance-vehicle', PrinMaintenanceController::class)->name('print-maintenance-vehicle');
