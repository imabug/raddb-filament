<?php

namespace App\Filament\Admin\Resources\Facilities\Tables;

use App\Filament\Actions\TableEditAction;
use App\Filament\Actions\TableViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class FacilitiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
                   ->columns([
                       TextColumn::make('id'),
                       TextColumn::make('facility')
                           ->searchable()
                           ->sortable(),
                   ])
                   ->filters([
                       TrashedFilter::make(),
                   ])
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
                   ])
                   ->defaultSort('facility', 'asc');
    }
}
