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
                    ->relationship('machine', 'description')
                    ->required(),
                Select::make('housing_manuf_id')
                    ->label('Housing manufacturer')
                    ->relationship(name: 'housing_manuf', titleAttribute: 'manufacturer')
                    ->default(null),
                TextInput::make('housing_model')
                    ->default(null),
                TextInput::make('housing_sn')
                    ->default(null),
                Select::make('insert_manuf_id')
                    ->label('Insert manufacturer')
                    ->relationship(name: 'insert_manuf', titleAttribute: 'manufacturer')
                    ->default(null),
                TextInput::make('insert_model')
                    ->default(null),
                TextInput::make('insert_sn')
                    ->default(null),
                DatePicker::make('manuf_date')
                    ->label('Manufacture date')
                    ->format('Y-m-d')
                    ->displayFormat('Y-m-d'),
                DatePicker::make('install_date')
                    ->label('Installation date')
                    ->format('Y-m-d')
                    ->displayFormat('Y-m-d'),
                DatePicker::make('remove_date')
                    ->label('Removal date')
                    ->format('Y-m-d')
                    ->displayFormat('Y-m-d'),
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
