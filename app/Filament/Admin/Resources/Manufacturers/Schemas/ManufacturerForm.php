<?php

namespace App\Filament\Admin\Resources\Manufacturers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ManufacturerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('manufacturer')
                    ->default(null),
            ]);
    }
}
