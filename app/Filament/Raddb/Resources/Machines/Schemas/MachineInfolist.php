<?php

namespace App\Filament\Raddb\Resources\Machines\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MachineInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('modality.modality'),
                TextEntry::make('description'),
                TextEntry::make('manufacturer.manufacturer'),
                TextEntry::make('vend_site_id'),
                TextEntry::make('model'),
                TextEntry::make('serial_number'),
                TextEntry::make('manuf_date')
                    ->date(),
                TextEntry::make('install_date')
                    ->date(),
                TextEntry::make('remove_date')
                    ->date(),
                TextEntry::make('location.location'),
                TextEntry::make('room'),
                TextEntry::make('machine_status'),
                TextEntry::make('photo'),
                TextEntry::make('deleted_at')
                    ->dateTime(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
                TextEntry::make('software_version'),
                TextEntry::make('pacs_station'),
            ]);
    }
}
