<?php

namespace App\Filament\Admin\Resources\Locations\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LocationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('facility_id')
                    ->relationship(name: 'facility', titleAttribute: 'facility')
                    ->required(),
                TextInput::make('location')
                    ->required()
                    ->string()
                    ->maxLength(100),
            ]);
    }
}
