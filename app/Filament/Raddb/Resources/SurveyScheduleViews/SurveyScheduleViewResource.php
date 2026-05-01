<?php

namespace App\Filament\Raddb\Resources\SurveyScheduleViews;

//use App\Filament\Raddb\Resources\SurveyScheduleViews\Pages\CreateSurveyScheduleView;
//use App\Filament\Raddb\Resources\SurveyScheduleViews\Pages\EditSurveyScheduleView;
use App\Filament\Raddb\Resources\SurveyScheduleViews\Pages\ListSurveyScheduleViews;
use App\Filament\Raddb\Resources\SurveyScheduleViews\Schemas\SurveyScheduleViewForm;
use App\Filament\Raddb\Resources\SurveyScheduleViews\Tables\SurveyScheduleViewsTable;
use App\Models\SurveyScheduleView;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SurveyScheduleViewResource extends Resource
{
    protected static ?string $model = SurveyScheduleView::class;

    protected static ?string $navigationLabel = "Survey Schedule";

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CalendarDays;

    protected static ?string $recordTitleAttribute = 'description';

    protected static ?string $modelLabel = 'Survey Schedule';

    protected static ?string $pluralModelLabel = 'Survey Schedule';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('machine')->orderBy('prevSurveyDate', 'asc');
    }

    public static function form(Schema $schema): Schema
    {
        return SurveyScheduleViewForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SurveyScheduleViewsTable::configure($table);
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
            'index' => ListSurveyScheduleViews::route('/'),
            //            'create' => CreateSurveyScheduleView::route('/create'),
            //            'edit' => EditSurveyScheduleView::route('/{record}/edit'),
        ];
    }
}
