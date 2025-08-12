<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        /* Variables de colores */
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --success: #27ae60;
            --warning: #f39c12;
            --danger: #e74c3c;
            --light: #f8f9fa;
            --gray: #95a5a6;
            --border: #e0e6ed;
        }

        body {
            font-family: 'Segoe UI', 'DejaVu Sans', sans-serif;
            /* color: #333;
            line-height: 1.35; */
            font-size: 10px;
            /* background-color: white; */
            /* padding: 15px;
            margin: 0; */
        }

        /* Cada vehículo en página separada */
        .page {
            page-break-after: always;
            max-width: 1000px;
            margin: 0 auto;
            position: relative;
            padding-top: 10px;
        }

        /* Encabezado personalizado */
        header {
            margin-bottom: 15px;
            padding-bottom: 12px;
            /* border-bottom: 2px solid var(--primary); */
        }

        .header-container {
            display: table;
            width: 100%;
        }

        .header-cell {
            display: table-cell;
            vertical-align: top;
        }

        .logo {
            text-align: center;
            line-height: 80px;
            font-size: 10pt;
        }

        .logo img {
            max-height: 140px;
            /* antes era 70px */
            max-width: 240px;
            /* antes era 140px */
        }

        .center-space {
            width: 60%;
            padding: 0 10px;
        }

        .company-info {
            text-align: right;
            font-size: 10pt;
            line-height: 1.2em;
            padding: 20px;
            width: 150px;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: #f8f9fa;
        }

        .company-info .name {
            font-weight: 600;
            font-size: 16pt;
            margin-top: 8px;
            margin-bottom: 6px;
            color: var(--primary);
        }

        .company-info .info-group>div {
            margin: 1px 0;
            color: var(--gray);
        }

        /* Información del vehículo */
        .vehicle-info {
            background-color: white;
            border-radius: 6px;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid var(--border);
            position: relative;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
        }

        .vehicle-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px dashed var(--border);
        }

        .vehicle-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 2px;
        }

        .vehicle-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            font-size: 9px;
            color: var(--gray);
        }

        .status-badge {
            background: var(--primary);
            color: white;
            padding: 3px 10px;
            border-radius: 30px;
            font-size: 9px;
            font-weight: 600;
        }

        /* Mantenimientos realizados */
        .section {
            margin-bottom: 15px;
        }

        .section-title {
            font-size: 12px;
            font-weight: 700;
            padding: 6px 10px;
            background-color: #f8f9fa;
            border-radius: 4px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--primary);
            border-left: 3px solid var(--secondary);
        }

        /* Tablas compactas */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .table th {
            background-color: var(--primary);
            color: white;
            text-align: left;
            padding: 6px 8px;
            font-weight: 600;
            font-size: 9px;
        }

        .table td {
            padding: 6px 8px;
            border-bottom: 1px solid var(--border);
            font-size: 9px;
        }

        .table tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        /* Estado */
        .status-indicator {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 4px;
        }

        .status-done {
            background-color: var(--success);
        }

        .status-pending {
            background-color: var(--danger);
        }

        /* Barras de progreso mejoradas */
        .progress-container {
            position: relative;
            height: 14px;
            background-color: #edf2f7;
            border-radius: 7px;
            overflow: hidden;
            margin: 3px 0;
        }

        .progress-fill {
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            min-width: 20px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding-right: 4px;
            box-sizing: border-box;
        }

        .progress-success {
            background-color: var(--success);
        }

        .progress-warning {
            background-color: var(--warning);
        }

        .progress-danger {
            background-color: var(--danger);
        }

        .progress-value {
            font-size: 7px;
            font-weight: 700;
            color: white;
            text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 2;
        }

        /* Layout compacto */
        .compact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 12px;
        }

        .compact-section {
            background-color: #f8f9fa;
            border-radius: 5px;
            padding: 10px;
            border: 1px solid var(--border);
        }

        .compact-title {
            font-size: 10px;
            font-weight: 600;
            margin-bottom: 6px;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Agrupación por fecha */
        .date-group {
            margin-bottom: 10px;
            padding-bottom: 8px;
            border-bottom: 1px dashed var(--border);
        }

        .date-header {
            font-weight: 700;
            font-size: 9px;
            color: var(--primary);
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Archivos adjuntos */
        .attachments {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 8px;
            margin-top: 8px;
        }

        .attachment {
            background-color: white;
            border-radius: 4px;
            padding: 6px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            border: 1px solid var(--border);
        }

        .attachment-icon {
            font-size: 16px;
            margin-bottom: 4px;
            color: var(--secondary);
        }

        .attachment-name {
            font-size: 8px;
            font-weight: 500;
            color: var(--primary);
            word-break: break-all;
        }

        /* Pie de página */
        footer {
            position: fixed;
            bottom: -60px;
            left: 0px;
            right: 0px;
            height: 50px;
            padding: 10px 20px;
            font-size: 9pt;
            text-align: center;
            border-top: 1px solid var(--border);
            color: var(--gray);
        }

        /* Elementos decorativos */
        .watermark {
            position: absolute;
            bottom: 20px;
            right: 15px;
            opacity: 0.03;
            font-size: 80px;
            font-weight: 800;
            color: var(--primary);
            transform: rotate(-15deg);
            pointer-events: none;
        }

        /* Mensaje sin datos */
        .no-data {
            text-align: center;
            padding: 20px;
            color: var(--gray);
            font-size: 10px;
        }

        .no-data-icon {
            font-size: 30px;
            margin-bottom: 8px;
            opacity: 0.3;
        }
    </style>
</head>

<body>
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
            <header>
                <div class="header-container">
                    <div class="header-cell">
                        <div class="logo">
                            <!-- Logo en base64 -->
                            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/logo.png'))) }}"
                                alt="Logo">
                        </div>
                    </div>

                    <div class="header-cell center-space">
                        {{-- <div style="text-align: center; padding-top: 20px;">
                            <div style="font-weight: bold; font-size: 16px; color: var(--primary);">
                                REPORTE DE MANTENIMIENTO
                            </div>
                            <div style="font-size: 10px; color: var(--gray); margin-top: 3px;">
                                Sistema de Gestión de Flota Vehicular
                            </div>
                        </div> --}}
                    </div>

                    <div class="header-cell company-info">
                        <div class="name" style="font-size: 16px;">{{ $vehicle->placa }}</div>
                        <div class="info-group">
                            <div><span style="font-weight: bold; color: var(--primary)">Marca:</span>  {{ $vehicle->marca }}</div>
                            <div><span style="font-weight: bold; color: var(--primary)">Unidad: </span> {{ $vehicle->unidad }}</div>
                            <div><span style="font-weight: bold; color: var(--primary)">Código: </span> {{ $vehicle->code }}</div>
                            <div><span style="font-weight: bold; color: var(--primary)">Tarjeta: </span> {{ $vehicle->property_card }}</div>
                            <div><span style="font-weight: bold; color: var(--primary)">KM: </span> {{ number_format(optional($maintenances->first())->mileage ?? 0) }}</div>
                        </div>
                    </div>
                </div>
            </header>

            <div class="vehicle-info">
                <div class="watermark">{{ $vehicle->code }}</div>

                <div class="vehicle-header">
                    <div>
                        <div class="vehicle-title">{{ $vehicle->marca }} - {{ $vehicle->placa }}</div>
                        <div class="vehicle-meta">
                            <span>Estado: {{ $vehicle->status }}</span>
                            <span>Última revisión:
                                {{ $maintenances->first()->brake_pads_checked_at?->format('d/m/Y') ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="status-badge">Pág. {{ $loop->iteration }}/{{ $loop->count }}</div>
                </div>

                @if (count($grouped) > 0)
                    <!-- Mantenimientos realizados -->
                    <div class="section">
                        <div class="section-title">
                            📝 MANTENIMIENTOS REALIZADOS
                        </div>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th width="50%">ITEM</th>
                                    <th width="25%">CATEGORÍA</th>
                                    <th width="25%">ESTADO</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($grouped as $category => $items)
                                    @foreach ($items as $item)
                                        <tr>
                                            <td>{{ $item->maintenanceItem->name ?? 'General' }}</td>
                                            <td>{{ $category }}</td>
                                            <td>
                                                @if ($item->is_done)
                                                    <span class="status-indicator status-done"></span>
                                                    REALIZADO
                                                @else
                                                    <span class="status-indicator status-pending"></span>
                                                    PENDIENTE
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Layout compacto para pastillas y costos -->
                    <div class="compact-grid">
                        <!-- Pastillas de freno agrupadas por fecha -->
                        <div class="compact-section">
                            <div class="compact-title">🛑 ESTADO DE PASTILLAS</div>

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
                        </div>

                        <!-- Costos -->
                        <div class="compact-section">
                            <div class="compact-title">💰 COSTOS (S/.)</div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>CONCEPTO</th>
                                        <th>VALOR</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($maintenances as $item)
                                        <tr>
                                            <td>Materiales</td>
                                            <td>{{ number_format($item->material_cost, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Mano de obra</td>
                                            <td>{{ number_format($item->labor_cost, 2) }}</td>
                                        </tr>
                                        <tr style="background-color: #e1f0fa; font-weight: 600;">
                                            <td>Total</td>
                                            <td>{{ number_format($item->total_cost, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Archivos adjuntos -->
                    @if ($maintenances->contains('photo_path') || $maintenances->contains('file_path'))
                        <div class="section">
                            <div class="section-title">
                                📎 ARCHIVOS ADJUNTOS
                            </div>

                            <div class="attachments">
                                @foreach ($maintenances as $item)
                                    @if ($item->photo_path)
                                        <div class="attachment">
                                            <div class="attachment-icon">🖼️</div>
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
                @else
                    <div class="no-data">
                        <div class="no-data-icon">🔧</div>
                        <div>NO SE ENCONTRARON MANTENIMIENTOS</div>
                    </div>
                @endif
            </div>

            <!-- Pie de página -->
            <footer>
                Generado el {{ now()->format('d/m/Y H:i') }} | Sistema de Gestión de Flota
            </footer>
        </div>
    @endforeach
</body>

</html>
