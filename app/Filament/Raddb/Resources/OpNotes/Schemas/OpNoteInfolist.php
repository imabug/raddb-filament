<?php

namespace App\Filament\Raddb\Resources\OpNotes\Schemas;

use App\Models\OpNote;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class OpNoteInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('machine.id')
                    ->label('Machine'),
                TextEntry::make('note')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn(OpNote $record): bool => $record->trashed()),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
