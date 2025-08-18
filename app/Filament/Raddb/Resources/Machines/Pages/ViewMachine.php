<?php

namespace App\Filament\Raddb\Resources\Machines\Pages;

use App\Filament\Raddb\Resources\Machines\MachineResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMachine extends ViewRecord
{
    protected static string $resource = MachineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
