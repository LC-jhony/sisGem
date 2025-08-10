<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class PrinMaintenanceController extends Controller
{
    const CHUNK_SIZE = 500; // Vehículos por lote

    public function __invoke(Request $request)
    {
        // Increase execution time limit for large reports
        set_time_limit(300); // 5 minutes

        $month = $request->integer('month');
        $startDate = $request->date('start_date');
        $endDate = $request->date('end_date');

        $zipFileName = 'reportes-mantenimientos-'.now()->format('YmdHis').'.zip';
        $zipPath = storage_path('app/public/'.$zipFileName);
        $zip = new ZipArchive;
        $zip->open($zipPath, ZipArchive::CREATE);

        // Process vehicles in smaller chunks to avoid memory issues
        Vehicle::where('status', 'Operativo')
            ->with(['maintenances' => function ($query) use ($month, $startDate, $endDate) {
                $query->where(function ($q) use ($month, $startDate, $endDate) {
                    $dateColumn = 'brake_pads_checked_at';

                    if ($month) {
                        $q->whereMonth($dateColumn, $month);
                    }

                    if ($startDate) {
                        $q->whereDate($dateColumn, '>=', $startDate);
                    }

                    if ($endDate) {
                        $q->whereDate($dateColumn, '<=', $endDate);
                    }
                })
                    ->with('maintenanceItem')
                    ->orderByDesc('brake_pads_checked_at');
            }])
            ->chunk(50, function ($vehicles) use ($zip, $month, $startDate, $endDate) {
                foreach ($vehicles as $vehicle) {
                    // Solo generar PDF si tiene mantenimientos
                    if ($vehicle->maintenances && $vehicle->maintenances->isNotEmpty()) {
                        try {
                            $pdf = Pdf::loadView('pdf.print_mantenance', [
                                'vehicle' => $vehicle,
                                'maintenances' => $vehicle->maintenances,
                                'filters' => [
                                    'month' => $month,
                                    'start_date' => $startDate?->format('Y-m-d'),
                                    'end_date' => $endDate?->format('Y-m-d'),
                                ],
                            ])->setPaper('a4', 'portrait');

                            $pdfContent = $pdf->output();
                            $fileName = "mantenimiento-{$vehicle->placa}.pdf";
                            $zip->addFromString($fileName, $pdfContent);

                            // Clear PDF from memory
                            unset($pdf, $pdfContent);
                        } catch (Exception $e) {
                            Log::error("Error generating PDF for vehicle {$vehicle->placa}: ".$e->getMessage());

                            continue;
                        }
                    }
                }

                // Clear chunk from memory
                unset($vehicles);
            });

        $zip->close();

        return Storage::disk('public')->download($zipFileName);
    }
}
