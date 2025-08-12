<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Vehicle;
use Filament\Forms\Form;
use App\Enum\MillageItems;
use App\Models\Mantenance;
use Filament\Tables\Table;
use Filament\Support\RawJs;
use App\Models\MaintenanceItem;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\MantenanceResource\Pages;

class MantenanceResource extends Resource
{
    protected static ?string $model = Mantenance::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?string $navigationGroup = 'Mantenimiento';

    protected static ?string $modelLabel = 'Mantenimiento';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Forms\Components\Section::make('Archivos')
                ->columns(2)
                ->schema([
                    Forms\Components\FileUpload::make('photo_path')
                        ->label('Foto del Mantenimiento')
                        ->disk('public')
                        ->directory('maintenance/photos')
                        ->visibility('public')
                        ->default(null)
                        ->helperText(str('La Foto  **del Mantenimiento** debe de subirlo para el mantenimiento.')->inlineMarkdown()->toHtmlString()),
                    Forms\Components\FileUpload::make('file_path')
                        ->label('Archivo del Mantenimiento')
                        ->disk('public')
                        ->directory('maintenance/files')
                        // ->acceptedFileTypes(['application/pdf'])
                        ->helperText(str('El archivo  **Boleta, Factura** debe de subirlo para el mantenimiento.')->inlineMarkdown()->toHtmlString()),
                ]),
            Forms\Components\Grid::make()
                ->columns(2)
                ->schema([
                Forms\Components\Select::make('vehicle_id')
                    ->label('Vehiculo')
                    ->options(Vehicle::all()->pluck('placa', 'id'))
                    ->searchable()
                    ->preload()
                    ->native(false)
                    ->required(),
                Forms\Components\Select::make('maintenance_item_id')
                    ->label('Mantenimiento')
                    ->options(MaintenanceItem::all()->pluck('name', 'id'))
                    ->label('Mantenimiento')
                    ->searchable()
                    ->preload()
                    ->native(false)
                    ->required(),
                Forms\Components\Select::make('mileage')
                    ->label('kilometro')
                    ->options(MillageItems::class)
                    ->searchable()
                    ->preload()
                    ->native(false)
                    ->required(),
                // Forms\Components\Toggle::make('status')
                //     ->required()
                //     ->default(true),
                Forms\Components\Select::make('status')
                    ->label('Estado')
                    ->options([
                        '1' => 'Si',
                        '0' => 'No',
                    ])
                    ->disabled()
                    ->dehydrated()
                    ->default('1'),
                Forms\Components\Section::make('Pastilla de Freno')
                    //->icon('iconpark-brakepads-o')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('front_left_brake_pad')
                        ->label('Pastilla delantera izquierda')
                        ->prefix('%')
                        ->numeric(),
                    Forms\Components\TextInput::make('front_right_brake_pad')
                        ->label('Pastilla delantera derecha')
                        ->prefix('%')
                        ->numeric(),
                    Forms\Components\TextInput::make('rear_left_brake_pad')
                            ->label('Pastilla trasera izquierda')
                            ->prefix('%')
                            ->numeric(),
                        Forms\Components\TextInput::make('rear_right_brake_pad')
                            ->label('Pastilla trasera derecha')
                            ->prefix('%')
                            ->numeric(),
                        Forms\Components\DatePicker::make('brake_pads_checked_at')
                            ->label('Fecha de Verificación')
                            ->default(now())
                            ->disabled()
                            ->dehydrated()
                            ->required()
                            ->native(false),
                    ]),
                Forms\Components\Section::make('Costos')
                    ->description('Valorizado del Mantenimiento Vehicular')
                    ->icon('heroicon-o-currency-dollar')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('Price_material')
                            ->label('Precio Material')
                            ->prefix('S/.')
                            // ->inputMode('decimal')
                            // ->mask(RawJs::make('$money($input, \',\')'))
                            ->numeric()
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set, $get) {
                            $workforce = floatval($get('workforce') ?? 0);
                            $set('maintenance_cost', floatval($state) + $workforce);
                        }),
                    Forms\Components\TextInput::make('workforce')
                        ->label('Mano de Obra')
                        ->prefix('S/.')
                        // ->inputMode('decimal')
                        // ->mask(RawJs::make('$money($input, ",")'))
                        ->numeric()
                                ->reactive()
                                ->afterStateUpdated(function ($state, callable $set, $get) {
                                    $workforce = floatval($get('Price_material') ?? 0);
                                    $set('maintenance_cost', floatval($state) + $workforce);
                                }),
                            Forms\Components\TextInput::make('maintenance_cost')
                                ->label('Costo Total')
                                ->prefix('S/.')
                                ->inputMode('decimal')
                                ->mask(RawJs::make('$money($input, ",")'))
                                ->numeric(),
                        ]),

                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('vehicle.placa')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('maintenanceItem.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mileage')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_done')
                    ->boolean(),
                Tables\Columns\TextColumn::make('material_cost')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('labor_cost')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_cost')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('photo_path')
                    ->searchable(),
                Tables\Columns\TextColumn::make('file_path')
                    ->searchable(),
                Tables\Columns\TextColumn::make('front_left_brake_pad')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('front_right_brake_pad')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rear_left_brake_pad')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rear_right_brake_pad')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('brake_pads_checked_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
            SelectFilter::make('is_done')
                ->options([
                    '1' => '✅ Completado',
                    '0' => '⏳ Pendiente',
                ])
                ->native(false),
            Filter::make('Rango de Fechas')
                ->form([
                    Forms\Components\DatePicker::make('start_date')
                        ->label('Fecha de inicio')
                        ->native(false)
                        ->placeholder('Selecciona fecha de inicio')
                        ->displayFormat('d/m/Y')
                        ->format('Y-m-d'),
                    Forms\Components\DatePicker::make('end_date')
                        ->label('Fecha de fin')
                        ->native(false)
                        ->placeholder('Selecciona fecha de fin')
                        ->displayFormat('d/m/Y')
                        ->format('Y-m-d')
                        ->after('start_date'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['start_date'],
                            fn(Builder $query, $date): Builder => $query->whereDate('brake_pads_checked_at', '>=', $date),
                        )
                        ->when(
                            $data['end_date'],
                            fn(Builder $query, $date): Builder => $query->whereDate('brake_pads_checked_at', '<=', $date),
                        );
                })
                ->indicateUsing(function (array $data): array {
                    $indicators = [];

                    if ($data['start_date'] ?? null) {
                        $indicators['start_date'] = 'Desde: ' . \Carbon\Carbon::parse($data['start_date'])->format('d/m/Y');
                    }

                    if ($data['end_date'] ?? null) {
                        $indicators['end_date'] = 'Hasta: ' . \Carbon\Carbon::parse($data['end_date'])->format('d/m/Y');
                    }

                    return $indicators;
                })

        ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListMantenances::route('/'),
            'create' => Pages\CreateMantenance::route('/create'),
            'view' => Pages\ViewMantenance::route('/{record}'),
            'edit' => Pages\EditMantenance::route('/{record}/edit'),
        ];
    }
}
