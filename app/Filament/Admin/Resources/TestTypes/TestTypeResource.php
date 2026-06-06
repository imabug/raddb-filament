<?php

namespace App\Filament\Admin\Resources\TestTypes;

use App\Filament\Admin\Resources\TestTypes\Pages\CreateTestType;
use App\Filament\Admin\Resources\TestTypes\Pages\EditTestType;
use App\Filament\Admin\Resources\TestTypes\Pages\ListTestTypes;
use App\Filament\Admin\Resources\TestTypes\Schemas\TestTypeForm;
use App\Filament\Admin\Resources\TestTypes\Tables\TestTypesTable;
use App\Models\TestType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TestTypeResource extends Resource
{
    protected static ?string $model = TestType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $recordTitleAttribute = 'testtype';

    public static function form(Schema $schema): Schema
    {
        return TestTypeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TestTypesTable::configure($table);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
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
            'index' => ListTestTypes::route('/'),
            'create' => CreateTestType::route('/create'),
            'edit' => EditTestType::route('/{record}/edit'),
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
