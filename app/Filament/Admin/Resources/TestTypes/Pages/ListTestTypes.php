<?php

namespace App\Filament\Admin\Resources\TestTypes\Pages;

use App\Filament\Admin\Resources\TestTypes\TestTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTestTypes extends ListRecords
{
    protected static string $resource = TestTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
