<?php

namespace App\Filament\Admin\Resources\Modalities\Pages;

use App\Filament\Admin\Resources\Modalities\ModalityResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListModalities extends ListRecords
{
    protected static string $resource = ModalityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
