<?php

namespace App\Filament\Raddb\Resources\Tubes\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class TubeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('machine_id')
                    ->relationship('machine', 'id')
                    ->required(),
                Select::make('housing_manuf_id')
                    ->relationship('housing_manuf', 'id')
                    ->default(null),
                TextInput::make('housing_model')
                    ->default(null),
                TextInput::make('housing_sn')
                    ->default(null),
                Select::make('insert_manuf_id')
                    ->relationship('insert_manuf', 'id')
                    ->default(null),
                TextInput::make('insert_model')
                    ->default(null),
                TextInput::make('insert_sn')
                    ->default(null),
                DatePicker::make('manuf_date'),
                DatePicker::make('install_date'),
                DatePicker::make('remove_date'),
                TextInput::make('lfs')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('mfs')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('sfs')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                Select::make('tube_status')
                    ->options(['Active' => 'Active', 'Removed' => 'Removed'])
                    ->required(),
                Textarea::make('notes')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
