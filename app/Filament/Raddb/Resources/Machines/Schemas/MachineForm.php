<?php

namespace App\Filament\Raddb\Resources\Machines\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class MachineForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('modality_id')
                    ->relationship('modality', 'id')
                    ->required()
                    ->default(0),
                TextInput::make('description')
                    ->default(null),
                Select::make('manufacturer_id')
                    ->relationship('manufacturer', 'id')
                    ->required()
                    ->default(0),
                TextInput::make('vend_site_id')
                    ->default(null),
                TextInput::make('model')
                    ->default('NULL'),
                TextInput::make('serial_number')
                    ->default(null),
                DatePicker::make('manuf_date'),
                DatePicker::make('install_date'),
                DatePicker::make('remove_date'),
                Select::make('location_id')
                    ->relationship('location', 'id')
                    ->required()
                    ->default(0),
                TextInput::make('room')
                    ->default(null),
                TextInput::make('machine_status')
                    ->required()
                    ->default('Active'),
                Textarea::make('notes')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('photo')
                    ->default(null),
                TextInput::make('software_version')
                    ->default(null),
                TextInput::make('pacs_station')
                    ->default(null),
            ]);
    }
}
