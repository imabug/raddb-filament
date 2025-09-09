<?php

namespace App\Filament\Raddb\Resources\TestDates;

use App\Filament\Raddb\Resources\TestDates\Pages\CreateTestDate;
use App\Filament\Raddb\Resources\TestDates\Pages\EditTestDate;
use App\Filament\Raddb\Resources\TestDates\Pages\ListTestDates;
use App\Filament\Raddb\Resources\TestDates\Schemas\TestDateForm;
use App\Filament\Raddb\Resources\TestDates\Tables\TestDatesTable;
use App\Models\TestDate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TestDateResource extends Resource
{
    protected static ?string $model = TestDate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CalendarDays;

    protected static ?string $recordTitleAttribute = 'test_date';

    public static function form(Schema $schema): Schema
    {
        return TestDateForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TestDatesTable::configure($table);
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
            'index' => ListTestDates::route('/'),
            'create' => CreateTestDate::route('/create'),
            'edit' => EditTestDate::route('/{record}/edit'),
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
