<?php

namespace App\Filament\Admin\Resources\Modalities;

use App\Filament\Admin\Resources\Modalities\Pages\CreateModality;
use App\Filament\Admin\Resources\Modalities\Pages\EditModality;
use App\Filament\Admin\Resources\Modalities\Pages\ListModalities;
use App\Filament\Admin\Resources\Modalities\Schemas\ModalityForm;
use App\Filament\Admin\Resources\Modalities\Tables\ModalitiesTable;
use App\Models\Modality;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ModalityResource extends Resource
{
    protected static ?string $model = Modality::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'modality';

    public static function form(Schema $schema): Schema
    {
        return ModalityForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ModalitiesTable::configure($table);
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
            'index' => ListModalities::route('/'),
            'create' => CreateModality::route('/create'),
            'edit' => EditModality::route('/{record}/edit'),
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
