<?php

namespace App\Filament\Raddb\Resources\Tubes\Pages;

use App\Filament\Raddb\Resources\Tubes\TubeResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Arr;

class CreateTube extends CreateRecord
{
    protected static string $resource = TubeResource::class;

    protected function preserveFormDataWhenCreatingAnother(array $data): array
    {
        return Arr::only($data, ['machine_id']);
    }
}
