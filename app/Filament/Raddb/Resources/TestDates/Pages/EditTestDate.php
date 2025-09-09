<?php

namespace App\Filament\Raddb\Resources\TestDates\Pages;

use App\Filament\Raddb\Resources\TestDates\TestDateResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditTestDate extends EditRecord
{
    protected static string $resource = TestDateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
