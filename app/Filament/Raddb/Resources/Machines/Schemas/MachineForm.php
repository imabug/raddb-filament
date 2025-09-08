<?php

namespace App\Filament\Raddb\Resources\Machines\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class MachineForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('facility_id')
                    ->label('Facility')
                    ->relationship(name: 'facility', titleAttribute: 'facility')
                    ->required()
                    ->live(),
                Select::make('location_id')
                    ->label('Location')
                    ->relationship(
                        name: 'location',
                        titleAttribute: 'location',
                        modifyQueryUsing: fn (Builder $query, Get $get) => $query->where('facility_id', $get('facility_id'))
                    )
                    ->required(),
                Select::make('modality_id')
                    ->label('Modality')
                    ->relationship(name: 'modality', titleAttribute: 'modality')
                    ->required(),
                Select::make('manufacturer_id')
                    ->label('Manufacturer')
                    ->relationship(name: 'manufacturer', titleAttribute: 'manufacturer')
                    ->required(),
                TextInput::make('model')
                    ->default(null)
                    ->string()
                    ->maxLength(100),
                TextInput::make('serial_number')
                    ->default(null)
                    ->string()
                    ->maxLength(50),
                TextInput::make('description')
                    ->default(null)
                    ->string()
                    ->maxLength(100),
                TextInput::make('vend_site_id')
                    ->label('Vendor site ID')
                    ->string()
                    ->maxLength(25)
                    ->default(null),
                TextInput::make('room')
                    ->string()
                    ->maxLength(20)
                    ->default(null),
                DatePicker::make('manuf_date')
                    ->label('Manufacture date')
                    ->format('Y-m-d')
                    ->displayFormat('Y-m-d'),
                DatePicker::make('install_date')
                    ->label('Install date')
                    ->format('Y-m-d')
                    ->displayFormat('Y-m-d'),
                Select::make('machine_status')
                    ->options([
                        'Active' => 'Active',
                        'Inactive' => 'Inactive',
                        'Removed' => 'Removed',
                    ])
                    ->required()
                    ->default('Active'),
                TextInput::make('software_version')
                    ->string()
                    ->maxLength(50)
                    ->default(null),
                TextInput::make('pacs_station')
                    ->string()
                    ->maxLength(50)
                    ->default(null),
                Textarea::make('notes')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
