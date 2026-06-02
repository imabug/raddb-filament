<?php

namespace App\Filament\Widgets;

use App\Models\SurveyScheduleView;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class SurveyScheduleWidget extends TableWidget
{
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
                   ->query(fn (): Builder => SurveyScheduleView::query())
                   ->columns([
                       TextColumn::make('id')
                           ->label('Machine ID')
                           ->sortable(),
                       TextColumn::make('description')
                           ->label('Machine')
                           ->searchable(),
                       TextColumn::make('prevSurveyId')
                           ->label('Prev Survey ID')
                           ->sortable(),
                       TextColumn::make('prevSurveyDate')
                           ->label('Prev Survey Date')
                           ->date('Y-m-d')
                           ->sortable(),
                       TextColumn::make('currSurveyId')
                           ->label('Current Survey ID')
                           ->sortable(),
                       TextColumn::make('currSurveyDate')
                           ->label('Current Survey Date')
                           ->date('Y-m-d')
                           ->sortable(),
                   ])
                   ->defaultSort('prevSurveyId', direction: 'asc')
                   ->paginated(false)
                   ->striped()
                   ->filters([
                       //
                   ])
                   ->headerActions([
                       //
                   ])
                   ->recordActions([
                       //
                   ])
                   ->toolbarActions([
                       BulkActionGroup::make([
                           //
                       ]),
                   ]);
    }
}
