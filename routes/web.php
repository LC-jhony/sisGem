<?php

use App\Http\Controllers\PrinMaintenanceController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/print-maintenance-vehicle', PrinMaintenanceController::class)->name('print-maintenance-vehicle');
