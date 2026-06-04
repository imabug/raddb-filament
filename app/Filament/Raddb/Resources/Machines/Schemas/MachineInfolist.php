<?php

namespace App\Filament\Raddb\Resources\Machines\Schemas;

use App\Models\Machine;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MachineInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('facility.facility'),
                TextEntry::make('modality.modality'),
                TextEntry::make('description'),
                TextEntry::make('manufacturer.manufacturer'),
                TextEntry::make('vend_site_id'),
                TextEntry::make('model'),
                TextEntry::make('serial_number'),
                TextEntry::make('manuf_date')
                    ->date('Y-m-d')
                    ->placeholder('-'),
                TextEntry::make('install_date')
                    ->date('Y-m-d')
                    ->placeholder('-'),
                TextEntry::make('remove_date')
                    ->date('Y-m-d')
                    ->placeholder('-'),
                TextEntry::make('location.location'),
                TextEntry::make('room'),
                TextEntry::make('machine_status')
                    ->badge(),
                TextEntry::make('software_version'),
                TextEntry::make('pacs_station'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn(Machine $record): bool => $record->trashed())
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
