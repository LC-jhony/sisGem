<x-print>
    @foreach ($vehicles as $vehicleId => $maintenances)
        @php
            $vehicle = $maintenances->first()->vehicle;

            // Agrupar mantenimientos por categoría
            $grouped = $maintenances->groupBy(function ($item) {
                return optional($item->maintenanceItem)->category ?? 'General';
            });

            // Agrupar mantenimientos por fecha para pastillas
            $brakeGroups = $maintenances->groupBy(function ($item) {
                return $item->brake_pads_checked_at ? $item->brake_pads_checked_at->format('Y-m-d') : '0000-00-00';
            });
        @endphp
        <div class="page">
            <!-- Encabezado personalizado -->
            <div class="header">
                <div class="header-top">
                    <div class="logo">
                        <div class="logo-icon">
                            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/logo.png'))) }}"
                                alt="Logo" style="width: 140px;">
                        </div>
                        {{-- <div class="logo-text">AUTO CARE PRO</div> --}}
                    </div>
                    <div class="report-title">
                        <h1>REPORTE DE MANTENIMIENTO</h1>
                        <div class="report-number">
                            <strong style="font-widget: bold;"> Placa: </strong>
                            {{ $vehicle->placa }} <br>
                            <strong style="font-widget: bold;"> Mes: </strong>
                            {{ $maintenances->first()->brake_pads_checked_at?->translatedFormat('F') ?? 'N/A' }}
                        </div>

                    </div>
                </div>
                <div class="vehicle-info">
                    {{-- <h1 style="text-align: center; font-widget: bold; color: black; margin-bottom: 6px;">Datos del
                    Vehiculo</h1> --}}
                    <div class="info-item">
                        <div class="info-label">Vehículo</div>
                        <div class="highlight">{{ $vehicle->marca }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Unidad</div>
                        <div class="highlight">{{ $vehicle->unidad }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Tarjeta Propiedad</div>
                        <div class="highlight">{{ $vehicle->property_card }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Kilometraje</div>
                        <div class="highlight">{{ number_format(optional($maintenances->first())->mileage ?? 0) }} km
                        </div>
                    </div>s
                </div>
            </div>
            <!-- Fin Encabezado personalizado -->
            <main>
                <div class="section">
                    <div class="section-title">
                        MANTENIMIENTOS REALIZADOS
                    </div>
                </div>
                <!-- Mantenimientos realizados -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>KM</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>

                    <body>
                        @foreach ($maintenances as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->maintenanceItem->name ?? 'General' }}</td>
                                <td>{{ $item->is_done ? 'Realizado' : 'Pendiente' }}</td>
                                <td>{{ $item->mileage }}</td>
                                <td>{{ $item->brake_pads_checked_at?->format('d/m/Y') ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </body>
                </table>
                <!-- Fin Mantenimientos realizados -->
                <!-- Layout compacto para pastillas y costos -->
                <!-- Estado de Pastillas -->
                <div class="section">
                    <div class="section-title">
                        ESTADO DE PASTILLAS
                    </div>
                </div>
                @foreach ($brakeGroups as $date => $items)
                    <div class="date-group">
                        <div class="date-header">
                            📅
                            {{ $date === '0000-00-00' ? 'SIN FECHA' : \Carbon\Carbon::parse($date)->format('d/m/Y') }}
                        </div>

                        @foreach ($items as $item)
                            <table class="table" style="margin-bottom: 8px;">
                                <tbody>
                                    <tr>
                                        <td width="40%">Del. Izq.</td>
                                        <td width="60%">
                                            @php
                                                $value = $item->front_left_brake_pad;
                                                $colorClass =
                                                    $value >= 70
                                                        ? 'progress-success'
                                                        : ($value >= 30
                                                            ? 'progress-warning'
                                                            : 'progress-danger');
                                            @endphp
                                            <div class="progress-container">
                                                <div class="progress-fill {{ $colorClass }}"
                                                    style="width: {{ $value }}%">
                                                    <div class="progress-value">{{ $value }}%</div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Del. Der.</td>
                                        <td>
                                            @php
                                                $value = $item->front_right_brake_pad;
                                                $colorClass =
                                                    $value >= 70
                                                        ? 'progress-success'
                                                        : ($value >= 30
                                                            ? 'progress-warning'
                                                            : 'progress-danger');
                                            @endphp
                                            <div class="progress-container">
                                                <div class="progress-fill {{ $colorClass }}"
                                                    style="width: {{ $value }}%">
                                                    <div class="progress-value">{{ $value }}%</div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tras. Izq.</td>
                                        <td>
                                            @php
                                                $value = $item->rear_left_brake_pad;
                                                $colorClass =
                                                    $value >= 70
                                                        ? 'progress-success'
                                                        : ($value >= 30
                                                            ? 'progress-warning'
                                                            : 'progress-danger');
                                            @endphp
                                            <div class="progress-container">
                                                <div class="progress-fill {{ $colorClass }}"
                                                    style="width: {{ $value }}%">
                                                    <div class="progress-value">{{ $value }}%</div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tras. Der.</td>
                                        <td>
                                            @php
                                                $value = $item->rear_right_brake_pad;
                                                $colorClass =
                                                    $value >= 70
                                                        ? 'progress-success'
                                                        : ($value >= 30
                                                            ? 'progress-warning'
                                                            : 'progress-danger');
                                            @endphp
                                            <div class="progress-container">
                                                <div class="progress-fill {{ $colorClass }}"
                                                    style="width: {{ $value }}%">
                                                    <div class="progress-value">{{ $value }}%</div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        @endforeach
                    </div>
                @endforeach
                <!-- Fin Estado de Pastillas -->
                <div class="section">
                    <div class="section-title">
                        COSTOS (s/.)
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Descripcion</th>
                            <th>Fecha</th>
                            <th>Material</th>
                            <th>Mano de obra</th>
                            <th>Total</th>
                        </tr>
                    </thead>

                    <body>
                        @foreach ($maintenances as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->maintenanceItem->name ?? 'General' }}</td>
                                <td>{{ $item->brake_pads_checked_at?->format('d/m/Y') ?? 'N/A' }}</td>
                                <td>{{ number_format($item->material_cost, 2) }}</td>
                                <td>{{ number_format($item->labor_cost, 2) }}</td>
                                <td>{{ number_format($item->total_cost, 2) }}</td>
                            </tr>
                        @endforeach
                    </body>
                </table>

        <!-- Fotos -->
                <div class="images-section">
                    <h4 style="text-align: center; margin-bottom: 15px; color: #495057;">Imágenes de Mantenimiento</h4>

                      @if ($maintenances->contains('photo_path') || $maintenances->contains('file_path'))
                        <div class="section">
                            <div class="section-title">
                                📎 ARCHIVOS ADJUNTOS
                            </div>

                            <div class="attachments">
                                @foreach ($maintenances as $item)
                                    @if ($item->photo_path)
                                        <div class="attachment">
                                            <div class="attachment-icon">
                                            </div>
                                            <div class="attachment-name">FOTO</div>
                                            <div style="font-size: 7px; color: var(--secondary);">Ver/Descargar</div>
                                        </div>
                                    @endif

                                    @if ($item->file_path)
                                        <div class="attachment">
                                            <div class="attachment-icon">📄</div>
                                            <div class="attachment-name">DOCUMENTO</div>
                                            <div style="font-size: 7px; color: var(--secondary);">Ver/Descargar</div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                <!-- Fin Fotos -->
            </main>

        </div>
    @endforeach
</x-print>
