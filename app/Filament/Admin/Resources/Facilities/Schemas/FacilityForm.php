<?php

namespace App\Filament\Admin\Resources\Facilities\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FacilityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('facility')
                    ->required()
                    ->string()
                    ->maxLength(100),
            ]);
    }
}
