<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MantenanceResource\Pages;
use App\Models\Mantenance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

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
                Forms\Components\Select::make('vehicle_id')
                    ->relationship('vehicle', 'id')
                    ->required(),
                Forms\Components\Select::make('maintenance_item_id')
                    ->relationship('maintenanceItem', 'name')
                    ->required(),
                Forms\Components\TextInput::make('mileage')
                    ->required()
                    ->numeric(),
                Forms\Components\Toggle::make('is_done')
                    ->required(),
                Forms\Components\TextInput::make('material_cost')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('labor_cost')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('total_cost')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('photo_path')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('file_path')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('front_left_brake_pad')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('front_right_brake_pad')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('rear_left_brake_pad')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('rear_right_brake_pad')
                    ->numeric()
                    ->default(null),
                Forms\Components\DateTimePicker::make('brake_pads_checked_at'),
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
                //
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
