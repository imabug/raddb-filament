<?php

namespace App\Filament\Raddb\Resources\OpNotes\Pages;

use App\Filament\Raddb\Resources\OpNotes\OpNoteResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditOpNote extends EditRecord
{
    protected static string $resource = OpNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
