<x-print>
    <!-- Header -->
    <div class="header">
        <h1>🚗 Reporte Detallado de Mantenimiento Vehicular</h1>
        <p class="subtitle">Sistema de Gestión de Mantenimiento - Análisis Completo de Pastillas de Freno</p>
        <p class="date">Generado el {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

    <!-- Vehicle Information -->
    <div class="vehicle-info">
        <h2>📋 Información del Vehículo</h2>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Placa</div>
                <div class="info-value">{{ $vehicle->placa }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Marca</div>
                <div class="info-value">{{ $vehicle->marca }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Modelo</div>
                <div class="info-value">{{ $vehicle->modelo ?? 'N/A' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Año</div>
                <div class="info-value">{{ $vehicle->year ?? 'N/A' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Color</div>
                <div class="info-value">{{ $vehicle->color ?? 'N/A' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Unidad</div>
                <div class="info-value">{{ $vehicle->unidad ?? 'N/A' }}</div>
            </div>
        </div>
    </div>

    <!-- Filters Applied -->
    <div class="filters-section">
        <h3>🔍 Filtros Aplicados</h3>
        <div class="filters-grid">
            <div>
                <strong>Mes:</strong> 
                @if($filters['month'])
                    {{ $meses[$filters['month']] ?? $filters['month'] }}
                @else
                    Todos los meses
                @endif
            </div>
            <div>
                <strong>Desde:</strong> 
                {{ $filters['start_date'] ? \Carbon\Carbon::parse($filters['start_date'])->format('d/m/Y') : 'Sin límite' }}
            </div>
            <div>
                <strong>Hasta:</strong> 
                {{ $filters['end_date'] ? \Carbon\Carbon::parse($filters['end_date'])->format('d/m/Y') : 'Sin límite' }}
            </div>
        </div>
    </div>

    <!-- Maintenance Records -->
    <div class="maintenance-section">
        <h3>🔧 Registros de Mantenimiento y Estado de Pastillas de Freno</h3>
        
        @if($maintenances->isEmpty())
            <div style="text-align: center; padding: 30px; color: #7f8c8d; font-style: italic;">
                <p>No se encontraron registros de mantenimiento para este vehículo en el período especificado.</p>
            </div>
        @else
            <table class="maintenance-table">
                <thead>
                    <tr>
                        <th width="12%">Fecha de Revisión</th>
                        <th width="18%">Tipo de Mantenimiento</th>
                        <th width="10%">Costo (S/)</th>
                        <th width="8%">Estado</th>
                        <th width="52%">Estado Detallado de Pastillas de Freno</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($maintenances as $maintenance)
                    <tr>
                        <td style="text-align: center;">
                            @if($maintenance->brake_pads_checked_at)
                                <strong>{{ \Carbon\Carbon::parse($maintenance->brake_pads_checked_at)->format('d/m/Y') }}</strong><br>
                                <small style="color: #7f8c8d;">{{ \Carbon\Carbon::parse($maintenance->brake_pads_checked_at)->format('H:i') }}</small>
                            @else
                                <span style="color: #95a5a6; font-style: italic;">No registrada</span>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $maintenance->maintenanceItem->name ?? 'Mantenimiento General' }}</strong>
                        </td>
                        <td style="text-align: right; font-weight: bold;">
                            S/ {{ number_format($maintenance->total_cost, 2) }}
                        </td>
                        <td style="text-align: center;">
                            @if($maintenance->is_done)
                                <span class="status-completed">✓ Completado</span>
                            @else
                                <span class="status-pending">! Pendiente</span>
                            @endif
                        </td>
                        <td>
                            <div class="brake-pads-container">
                                @php
                                    $brakePads = [
                                        'FL' => [
                                            'value' => $maintenance->front_left_brake_pad ?? 0,
                                            'name' => 'Front Left'
                                        ],
                                        'FR' => [
                                            'value' => $maintenance->front_right_brake_pad ?? 0,
                                            'name' => 'Front Right'
                                        ],
                                        'RL' => [
                                            'value' => $maintenance->rear_left_brake_pad ?? 0,
                                            'name' => 'Rear Left'
                                        ],
                                        'RR' => [
                                            'value' => $maintenance->rear_right_brake_pad ?? 0,
                                            'name' => 'Rear Right'
                                        ]
                                    ];
                                @endphp
                                
                                @foreach($brakePads as $position => $data)
                                    @php
                                        $value = $data['value'];
                                        $class = match(true) {
                                            $value >= 80 => 'progress-excellent',
                                            $value >= 60 => 'progress-good',
                                            $value >= 40 => 'progress-warning',
                                            $value >= 20 => 'progress-danger',
                                            default => 'progress-critical'
                                        };
                                        
                                        $statusClass = match(true) {
                                            $value >= 80 => 'status-excellent',
                                            $value >= 60 => 'status-good',
                                            $value >= 40 => 'status-warning',
                                            $value >= 20 => 'status-danger',
                                            default => 'status-critical'
                                        };
                                        
                                        $status = match(true) {
                                            $value >= 80 => 'Excelente',
                                            $value >= 60 => 'Bueno',
                                            $value >= 40 => 'Atención',
                                            $value >= 20 => 'Crítico',
                                            default => 'Reemplazar'
                                        };
                                    @endphp
                                    
                                    <div class="brake-pad-row">
                                        <div class="brake-pad-label">{{ $position }}</div>
                                        <div class="progress-container">
                                            <div class="progress-bar {{ $class }}" style="width: {{ $value }}%">
                                                {{ $value }}%
                                            </div>
                                        </div>
                                        <div class="brake-pad-status {{ $statusClass }}">
                                            {{ $status }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Summary Statistics -->
    @if($maintenances->isNotEmpty())
    <div class="summary-section">
        <h3>📊 Resumen Estadístico del Vehículo</h3>
        <div class="summary-grid">
            @php
                $totalMaintenances = $maintenances->count();
                $completedMaintenances = $maintenances->where('is_done', true)->count();
                $totalCost = $maintenances->sum('total_cost');
                
                // Calculate average brake pad life
                $brakePadValues = [];
                foreach($maintenances as $m) {
                    $brakePadValues[] = $m->front_left_brake_pad ?? 0;
                    $brakePadValues[] = $m->front_right_brake_pad ?? 0;
                    $brakePadValues[] = $m->rear_left_brake_pad ?? 0;
                    $brakePadValues[] = $m->rear_right_brake_pad ?? 0;
                }
                $avgBrakePadLife = count($brakePadValues) > 0 ? round(array_sum($brakePadValues) / count($brakePadValues), 1) : 0;
                
                // Calculate critical brake pads (below 20%)
                $criticalBrakePads = 0;
                foreach($brakePadValues as $value) {
                    if($value < 20) $criticalBrakePads++;
                }
            @endphp
            
            <div class="summary-item">
                <div class="summary-value">{{ $totalMaintenances }}</div>
                <div class="summary-label">Total Mantenimientos</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">{{ $completedMaintenances }}</div>
                <div class="summary-label">Completados</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">S/ {{ number_format($totalCost, 2) }}</div>
                <div class="summary-label">Costo Total</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">{{ $avgBrakePadLife }}%</div>
                <div class="summary-label">Promedio Pastillas</div>
            </div>
        </div>
        
        @if($criticalBrakePads > 0)
        <div style="margin-top: 10px; padding: 8px; background-color: #fadbd8; border-radius: 4px; border-left: 4px solid #e74c3c;">
            <strong style="color: #e74c3c;">⚠️ Atención:</strong> 
            <span style="font-size: 9px; color: #c0392b;">
                Se detectaron {{ $criticalBrakePads }} pastillas de freno que requieren reemplazo inmediato (menos del 20% de vida útil).
            </span>
        </div>
        @endif
    </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p><strong>Sistema de Gestión de Mantenimiento Vehicular</strong></p>
        <p>Reporte generado automáticamente | Página generada el {{ now()->format('d/m/Y H:i:s') }}</p>
        <p style="font-size: 8px; margin-top: 5px;">
            <strong>Leyenda de Barras de Progreso:</strong> 
            <span style="color: #27ae60;">Excelente (80%+)</span> | 
            <span style="color: #f39c12;">Bueno (60-79%)</span> | 
            <span style="color: #e67e22;">Atención (40-59%)</span> | 
            <span style="color: #e74c3c;">Crítico (20-39%)</span> | 
            <span style="color: #8e44ad;">Reemplazar (<20%)</span>
        </p>
    </div>
</x-print>