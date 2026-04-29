<?php

namespace App\Filament\Raddb\Resources\SurveyScheduleViews\Tables;

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
                       TextColumn::make('id')
                           ->label('Machine ID'),
                       TextColumn::make('description')
                           ->label('Machine'),
                       TextColumn::make('prevSurveyId')
                           ->label('Prev Survey ID'),
                       TextColumn::make('prevSurveyDate')
                           ->label('Prev Survey Date')
                           ->date('Y-m-d'),
                       TextColumn::make('currSurveyId')
                           ->label('Current Survey ID'),
                       TextColumn::make('currSurveyDate')
                           ->label('Current Survey Date')
                           ->date('Y-m-d'),
                   ])
                   ->paginated(false)
                   ->striped();
    }
}
