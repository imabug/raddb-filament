<?php

namespace App\Filament\Raddb\Resources\Tubes\Pages;

use App\Filament\Raddb\Resources\Tubes\TubeResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTube extends ViewRecord
{
    protected static string $resource = TubeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
