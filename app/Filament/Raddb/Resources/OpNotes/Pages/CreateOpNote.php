<?php

namespace App\Filament\Raddb\Resources\OpNotes\Pages;

use App\Filament\Raddb\Resources\OpNotes\OpNoteResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Arr;

class CreateOpNote extends CreateRecord
{
    protected static string $resource = OpNoteResource::class;

    protected function preserveFormDataWhenCreatingAnother(array $data): array
    {
        return Arr::only($data, ['machine_id']);
    }
}
