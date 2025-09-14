<?php

namespace App\Filament\Raddb\Resources\Machines\Pages;

use App\Filament\Raddb\Resources\Machines\MachineResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Arr;

class CreateMachine extends CreateRecord
{
    protected static string $resource = MachineResource::class;

    protected function preserveFormDataWhenCreatingAnother(array $data): array
    {
        return Arr::only(
            $data,
            [
                'facility_id',
                'location_id',
                'modality_id',
            ]
        );
    }
}
