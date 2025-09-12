<?php

namespace App\Filament\Raddb\Resources\Tubes\Pages;

use App\Filament\Raddb\Resources\Tubes\TubeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTubes extends ListRecords
{
    protected static string $resource = TubeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
