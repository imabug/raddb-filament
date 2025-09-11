<?php

namespace App\Filament\Raddb\Resources\OpNotes\Pages;

use App\Filament\Raddb\Resources\OpNotes\OpNoteResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOpNotes extends ListRecords
{
    protected static string $resource = OpNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
