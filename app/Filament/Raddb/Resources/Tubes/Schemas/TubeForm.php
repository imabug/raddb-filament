<?php

namespace App\Filament\Raddb\Resources\Tubes\Schemas;

use App\Enums\Status;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class TubeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('machine_id')
                    ->relationship(
                        name: 'machine',
                        titleAttribute: 'description',
                        modifyQueryUsing: fn(Builder $query) => $query->active()
                    )
                    ->required(),
                Select::make('housing_manuf_id')
                    ->label('Housing manufacturer')
                    ->relationship(name: 'housing_manuf', titleAttribute: 'manufacturer')
                    ->default(null),
                TextInput::make('housing_model')
                    ->default(null),
                TextInput::make('housing_sn')
                    ->label('Housing serial number')
                    ->default(null),
                Select::make('insert_manuf_id')
                    ->label('Insert manufacturer')
                    ->relationship(name: 'insert_manuf', titleAttribute: 'manufacturer')
                    ->default(null),
                TextInput::make('insert_model')
                    ->default(null),
                TextInput::make('insert_sn')
                    ->label('Insert serial number')
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
                    ->label('Large focal spot size (mm)')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('mfs')
                    ->label('Medium focal spot size (mm)')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('sfs')
                    ->label('Small focal spot size (mm)')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                Select::make('tube_status')
                    ->options(Status::class)
                    ->default(Status::Active)
                    ->required(),
                Textarea::make('notes')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
