<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use App\Models\Vehicle;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Log;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Actions\ActionGroup;
use App\Filament\Resources\VehicleResource\Pages;

class VehicleResource extends Resource
{
    protected static ?string $model = Vehicle::class;

    protected static ?string $navigationIcon = 'mdi-excavator';

    protected static ?string $navigationGroup = 'Gestión de Personal';

    protected static ?string $modelLabel = 'Vehículos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('placa')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('marca')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('unidad')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('property_card')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('status')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->paginated([5, 10, 25, 50, 100, 'all'])
            ->defaultPaginationPageOption(5)
            ->searchable()
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('PROG.')
                    ->searchable(),
                Tables\Columns\TextColumn::make('placa')
                    ->label('Placa')
                    ->searchable(),
                Tables\Columns\TextColumn::make('marca')
                    ->label('Marca')
                    ->searchable(),
                Tables\Columns\TextColumn::make('unidad')
                    ->label('Unidad')
                    ->searchable(),
                Tables\Columns\TextColumn::make('property_card')
                    ->label('Tar. Propiedad')
                    ->searchable()
                    ->badge(),
                Tables\Columns\TextColumn::make('soat')
                    ->label('SOAT')
                    ->getStateUsing(function ($record) {
                        try {
                            if (! $documentSoat = $record->documents->firstWhere('name', 'SOAT')) {
                                return 'no-document';
                            }

                            return $documentSoat->date ? Carbon::parse($documentSoat->date) : null;
                        } catch (\Exception $e) {
                            Log::error("Error en SOAT [Vehículo {$record->id}]: " . $e->getMessage());

                            return 'invalid-date';
                        }
                    })
                    ->formatStateUsing(fn($state) => match (true) {
                        $state === 'no-document' => 'Sin SOAT',
                        $state === 'invalid-date' => 'Fecha inválida',
                        default => $state?->format('d/m/Y') ?? 'Sin fecha'
                    })
                    ->badge()
                    ->color(function ($state) {
                        if (! is_object($state)) {
                            return 'gray';
                        }

                        $dias = now()->diffInDays($state, false);

                        return match (true) {
                            $dias < 0 || $dias <= 7 => 'danger',
                            $dias <= 30 => 'warning',
                            default => 'success'
                        };
                    }),
                Tables\Columns\TextColumn::make('tarjeta')
                    ->label('Tarjeta')
                    ->getStateUsing(function ($record) {
                        try {
                            if (! $documentSoat = $record->documents->firstWhere('name', 'TARJETA DE CIRCULACION')) {
                                return 'no-document';
                            }

                            return $documentSoat->date ? Carbon::parse($documentSoat->date) : null;
                        } catch (\Exception $e) {
                            Log::error("Error en Tarjeta [Vehículo {$record->id}]: " . $e->getMessage());

                            return 'invalid-date';
                        }
                    })
                    ->formatStateUsing(fn($state) => match (true) {
                        $state === 'no-document' => 'Sin TARJETA',
                        $state === 'invalid-date' => 'Fecha inválida',
                        default => $state?->format('d/m/Y') ?? 'Sin fecha'
                    })
                    ->badge()
                    ->color(function ($state) {
                        if (! is_object($state)) {
                            return 'gray';
                        }
                        $dias = now()->diffInDays($state, false);
                        return match (true) {
                            $dias < 0 || $dias <= 7 => 'danger',
                            $dias <= 30 => 'warning',
                            default => 'success'
                        };
                    }),
                Tables\Columns\TextColumn::make('revision')
                    ->label('Revision')
                    ->getStateUsing(function ($record) {
                        try {
                            if (! $documentSoat = $record->documents->firstWhere('name', 'REVICION TECNICA')) {
                                return 'no-document';
                            }

                            return $documentSoat->date ? Carbon::parse($documentSoat->date) : null;
                        } catch (\Exception $e) {
                            Log::error("Error en Revision [Vehículo {$record->id}]: " . $e->getMessage());

                            return 'invalid-date';
                        }
                    })
                    ->formatStateUsing(fn($state) => match (true) {
                        $state === 'no-document' => 'Sin REVISIÓN',
                        $state === 'invalid-date' => 'Fecha inválida',
                        default => $state?->format('d/m/Y') ?? 'Sin fecha'
                    })
                    ->badge()
                    ->color(function ($state) {
                        if (! is_object($state)) {
                            return 'gray';
                        }

                        $dias = now()->diffInDays($state, false);

                        return match (true) {
                            $dias < 0 || $dias <= 7 => 'danger',
                            $dias <= 30 => 'warning',
                            default => 'success'
                        };
                    }),
                Tables\Columns\TextColumn::make('poliza')
                    ->label('Poliza')
                    ->getStateUsing(function ($record) {
                        try {
                            if (! $documentSoat = $record->documents->firstWhere('name', 'POLIZA DE SEGURO VEHICULAR')) {
                                return 'no-document';
                            }

                            return $documentSoat->date ? Carbon::parse($documentSoat->date) : null;
                        } catch (\Exception $e) {
                            Log::error("Error en POLIZA [Vehículo {$record->id}]: " . $e->getMessage());

                            return 'invalid-date';
                        }
                    })
                    ->formatStateUsing(fn($state) => match (true) {
                        $state === 'no-document' => 'Sin POLIZA',
                        $state === 'invalid-date' => 'Fecha inválida',
                        default => $state?->format('d/m/Y') ?? 'Sin fecha'
                    })
                    ->badge()
                    ->color(function ($state) {
                        if (! is_object($state)) {
                            return 'gray';
                        }
                        $dias = now()->diffInDays($state, false);
                        return match (true) {
                            $dias < 0 || $dias <= 7 => 'danger',
                            $dias <= 30 => 'warning',
                            default => 'success'
                        };
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->searchable()
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Operativo' => 'success',
                        'En Mantenimiento' => 'warning',
                        'Fuera de Servicio' => 'danger',
                        'En Reparación' => 'gray',
                        'Disponible' => 'info',
                        'En Uso' => 'success',
                        default => 'primary',
                    })
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->label('Eliminado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('view_maintenances')
                    ->label('Mantenimientos')
                    ->icon('heroicon-o-wrench-screwdriver')
                    ->color('warning')
                    ->modalContent(function ($record) {
                        return view('livewire.mantenance_modal', ['record' => $record]);
                    })
                    ->modalHeading(fn($record) => 'Mantenimientos - Vehículo: ' . $record->placa)
                    ->slideOver(true)
                    ->modalSubmitAction(false)
                    ->modalCancelAction(false)
                    ->modalWidth(MaxWidth::SevenExtraLarge),
                //  ->visible(fn ($record) => ! empty($record) && auth()->user()->hasAnyRole(['super_admin', 'Super Admin', 'Usuario'])),
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make()
                        ->color('primary'),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\ForceDeleteAction::make(),
                    Tables\Actions\RestoreAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVehicles::route('/'),
            'create' => Pages\CreateVehicle::route('/create'),
            'view' => Pages\ViewVehicle::route('/{record}'),
            'edit' => Pages\EditVehicle::route('/{record}/edit'),
        ];
    }
}
