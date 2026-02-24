<?php

namespace App\Filament\Raddb\Resources\TestDates\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
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
                TextColumn::make('type.test_type')
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
                    ->query(fn(Builder $query): Builder => $query->where('test_date', '>=', date('Y-m-d')))
                    ->toggle()
                    ->default(),
            ])
            ->deferFilters(false)
            ->recordActions([
                EditAction::make(),
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
