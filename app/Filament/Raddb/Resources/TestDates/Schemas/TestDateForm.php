<?php

namespace App\Filament\Raddb\Resources\TestDates\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class TestDateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('machine_id')
                    ->label('Machine')
                    ->relationship(name: 'machine', titleAttribute: 'description')
                    ->required(),
                Select::make('testtype_id')
                    ->label('Test type')
                    ->relationship(name: 'testtype', titleAttribute: 'test_type')
                    ->required(),
                DatePicker::make('test_date')
                    ->label('Survey date')
                    ->format('Y-m-d')
                    ->displayFormat('Y-m-d')
                    ->required(),
                TextInput::make('accession')
                    ->string()
                    ->maxLength(50)
                    ->default(null),
                Textarea::make('notes')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
