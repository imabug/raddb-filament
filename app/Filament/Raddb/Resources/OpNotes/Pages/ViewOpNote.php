<?php

namespace App\Filament\Raddb\Resources\OpNotes\Pages;

use App\Filament\Raddb\Resources\OpNotes\OpNoteResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewOpNote extends ViewRecord
{
    protected static string $resource = OpNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
