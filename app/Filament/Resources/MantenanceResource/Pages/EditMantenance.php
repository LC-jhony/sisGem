<?php

namespace App\Filament\Resources\MantenanceResource\Pages;

use App\Filament\Resources\MantenanceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMantenance extends EditRecord
{
    protected static string $resource = MantenanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
