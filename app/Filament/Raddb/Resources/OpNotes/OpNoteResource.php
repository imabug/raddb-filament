<?php

namespace App\Filament\Raddb\Resources\OpNotes;

use App\Filament\Raddb\Resources\OpNotes\Pages\CreateOpNote;
use App\Filament\Raddb\Resources\OpNotes\Pages\EditOpNote;
use App\Filament\Raddb\Resources\OpNotes\Pages\ListOpNotes;
use App\Filament\Raddb\Resources\OpNotes\Pages\ViewOpNote;
use App\Filament\Raddb\Resources\OpNotes\Schemas\OpNoteForm;
use App\Filament\Raddb\Resources\OpNotes\Schemas\OpNoteInfolist;
use App\Filament\Raddb\Resources\OpNotes\Tables\OpNotesTable;
use App\Models\OpNote;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OpNoteResource extends Resource
{
    protected static ?string $model = OpNote::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPencilSquare;

    protected static ?string $recordTitleAttribute = 'note';

    public static function form(Schema $schema): Schema
    {
        return OpNoteForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return OpNoteInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OpNotesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOpNotes::route('/'),
            'create' => CreateOpNote::route('/create'),
            'view' => ViewOpNote::route('/{record}'),
            'edit' => EditOpNote::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
