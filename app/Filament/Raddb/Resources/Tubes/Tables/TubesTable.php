<?php

namespace App\Filament\Raddb\Resources\Tubes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class TubesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('machine.id')
                    ->searchable(),
                TextColumn::make('housing_manuf.id')
                    ->searchable(),
                TextColumn::make('housing_model')
                    ->searchable(),
                TextColumn::make('housing_sn')
                    ->searchable(),
                TextColumn::make('insert_manuf.id')
                    ->searchable(),
                TextColumn::make('insert_model')
                    ->searchable(),
                TextColumn::make('insert_sn')
                    ->searchable(),
                TextColumn::make('manuf_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('install_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('remove_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('lfs')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('mfs')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('sfs')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('tube_status')
                    ->badge(),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
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
