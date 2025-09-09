<?php

namespace App\Filament\Raddb\Resources\TestDates\Pages;

use App\Filament\Raddb\Resources\TestDates\TestDateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTestDates extends ListRecords
{
    protected static string $resource = TestDateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
