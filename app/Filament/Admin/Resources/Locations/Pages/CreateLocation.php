<?php

namespace App\Filament\Admin\Resources\Locations\Pages;

use App\Filament\Admin\Resources\Locations\LocationResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Arr;

class CreateLocation extends CreateRecord
{
    protected static string $resource = LocationResource::class;

    protected function preserveFormDataWhenCreatingAnother(array $data): array
    {
        return Arr::only($data, ['facility_id']);
    }
}
