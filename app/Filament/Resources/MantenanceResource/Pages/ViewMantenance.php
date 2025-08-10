<?php

namespace App\Filament\Resources\MantenanceResource\Pages;

use App\Filament\Resources\MantenanceResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMantenance extends ViewRecord
{
    protected static string $resource = MantenanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
