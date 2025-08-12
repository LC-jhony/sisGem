<?php

namespace App\Http\Controllers;

use App\Models\Mantenance;
use App\Models\Vehicle;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class PrinMaintenanceController extends Controller
{


    public function __invoke(Request $request)
    {
        $month = $request->integer('month');
        $startDate = $request->date('start_date');
        $endDate = $request->date('end_date');

        $dateColumn = 'brake_pads_checked_at';

        $query = Mantenance::with(['vehicle', 'maintenanceItem']);

        if ($month) {
            $query->whereMonth($dateColumn, $month);
        }

        if ($startDate) {
            $query->whereDate($dateColumn, '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate($dateColumn, '<=', $endDate);
        }
        // Agrupa los mantenimientos por vehículo
        $vehicles = $query->get()->groupBy('vehicle_id');

        $dompdf = Pdf::loadView('pdf.print_mantenance', [
            'vehicles' => $vehicles,
            'filters' => [
                'month' => $month,
                'start_date' => $startDate?->format('Y-m-d'),
                'end_date' => $endDate?->format('Y-m-d'),
            ],
        ])->setPaper('a4', 'portrait');

        return $dompdf->stream('reporte-mantenimientos.pdf');
    }
}
