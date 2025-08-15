<x-app>

    <x-slot name='head'>
        <div class="report-title">
            <h1>REPORTE DE MANTENIMIENTO</h1>
            <div class="report-number">
                <strong style="font-widget: bold;"> Placa: </strong>
                {{ $record->placa }}
            </div>

        </div>
        </div>
        {{-- <div class="record-info">
            <div class="info-item">
                <div class="info-label">Vehículo</div>
                <div class="highlight">{{ $record->marca }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Unidad</div>
                <div class="highlight">{{ $record->unidad }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Tarjeta Propiedad</div>
                <div class="highlight">{{ $record->property_card }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Mes</div>
                <div class="highlight">
                    {{ $record->created_at }}
                </div>
            </div>s
        </div> --}}
    </x-slot>
    <br />
    <div class="section">
        <div class="section-title">
            Valorizado de Mantenimiento Vehicular
        </div>
    </div>
    @if ($record->maintenances->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 35%;">Descripción</th>
                    <th style="width: 12%;">KM</th>
                    <th style="width: 17%;">Precio Material</th>
                    <th style="width: 16%;">Mano de Obra</th>
                    <th style="width: 20%;">Costo Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($record->maintenances as $item)
                    <tr>
                        <td class="text-left">{{ $item->maintenanceItem->name ?? 'N/A' }}</td>
                        <td>{{ number_format($item->mileage) }}</td>
                        <td class="text-right">S/. {{ number_format($item->material_cost, 2) }}</td>
                        <td class="text-right">S/. {{ number_format($item->labor_cost, 2) }}</td>
                        <td class="text-right">S/. {{ number_format($item->total_cost, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="4" class="text-right"><strong>Total General:</strong></td>
                    <td class="text-right"><strong>S/.
                            {{ number_format($record->maintenances->sum('total_cost'), 2) }}</strong></td>
                </tr>
            </tfoot>
        </table>

    @php
        $hasImages = $records->filter(function($item) {
            return $item->photo_path || $item->file_path;
        })->count() > 0;
    @endphp

    
    @if($hasImages)
        <!-- Salto de página para las imágenes -->
        <div style="page-break-before: always;"></div>
        <!-- Contenedor para las imágenes que ocupen toda la página -->
        <div style="width: 100%; text-align: center;">
            @foreach ($records as $item)
                @if ($item->photo_path)
                    <div style="margin-bottom: 20px;">
                        <img src="{{ storage_path('app/public/' . $item->photo_path) }}"
                            style="width: 90%; max-width: 500px; border: 1px solid #ccc; padding: 5px;">
                    </div>
                @endif

                @if ($item->file_path)
                    <div style="margin-bottom: 20px;">
                        <img src="{{ storage_path('app/public/' . $item->file_path) }}"
                            style="width: 90%; max-width: 500px; border: 1px solid #ccc; padding: 5px;">
                    </div>
                @endif
            @endforeach
        </div>
    @endif
    {{-- @else
        <div class="no-images">
            <p>No hay registros de mantenimiento para este vehículo.</p>
        </div>
    @endif --}}
</x-app>
