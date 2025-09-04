<?php

namespace App\Filament\Raddb\Resources\SurveyScheduleViews\Tables;

//use Filament\Actions\BulkActionGroup;
//use Filament\Actions\DeleteBulkAction;
//use Filament\Actions\EditAction;
//use Filament\Support\Icons\Heroicon;
use App\Models\SurveyScheduleView;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SurveyScheduleViewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
                   ->heading('Survey Schedule')
                   ->columns([
                       TextColumn::make('id'),
                       TextColumn::make('description'),
                       TextColumn::make('prevSurveyId'),
                       TextColumn::make('prevSurveyDate')
                           ->date('Y-m-d'),
                       TextColumn::make('currSurveyId'),
                       TextColumn::make('currSurveyDate')
                           ->date('Y-m-d'),
                   ])
                   ->paginated(false)
                   ->striped();
        // ->filters([
        //     //
        // ]);
        // ->recordActions([
        //     EditAction::make(),
        // ])
        // ->toolbarActions([
        //     BulkActionGroup::make([
        //         DeleteBulkAction::make(),
        //     ]),
        // ]);
    }
}
