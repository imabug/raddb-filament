<?php

namespace App\Filament\Raddb\Resources\SurveyScheduleViews\Tables;

use App\Models\Facility;
use App\Models\SurveyScheduleView;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

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
                   ->striped()
                   ->filters([
                       SelectFilter::make('facility')
                           ->label('Facility')
                           ->multiple()
                           ->options(fn(): array => Facility::query()
                                                         ->pluck('facility', 'id')
                                                         ->all()),
                       Filter::make('surveyDateRange')
                           ->label('Survey date range')
                           ->schema([
                               DatePicker::make('surveyStart')
                                   ->label('Survey start date'),
                               DatePicker::make('surveyEnd')
                                   ->label('Survey end date'),
                           ])
                           ->query(function (Builder $query, array $data): Builder {
                               return $query
                                          ->when(
                                              $data['surveyStart'],
                                              fn(Builder $query, $date): Builder => $query->whereDate('currSurveyDate', '>=', $date),
                                          )
                                          ->when(
                                              $data['surveyEnd'],
                                              fn(Builder $query, $date): Builder => $query->whereDate('currSurveyDate', '<=', $date),
                                          );
                           }),
                   ]);
    }
}
