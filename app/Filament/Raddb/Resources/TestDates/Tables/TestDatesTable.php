<?php

namespace App\Filament\Raddb\Resources\TestDates\Tables;

use App\Filament\Actions\TableEditAction;
use App\Filament\Actions\TableViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TestDatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('machine.description')
                    ->searchable(),
                TextColumn::make('testtype.test_type')
                    ->sortable(),
                TextColumn::make('test_date')
                    ->date('Y-m-d')
                    ->sortable(),
                TextColumn::make('accession')
                    ->searchable(),
                TextColumn::make('notes'),
            ])
            ->filters([
                TrashedFilter::make(),
                Filter::make('pending')
                    ->query(fn (Builder $query): Builder => $query->activeMachines()->pending())
                    ->toggle()
                    ->default(),
                Filter::make('activeMachines')
                    ->label("Active machines")
                    ->query(fn (Builder $query): Builder => $query->activeMachines())
                    ->toggle(),
            ])
            ->deferFilters(false)
            ->recordActions([
                TableEditAction::make(),
                TableViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
