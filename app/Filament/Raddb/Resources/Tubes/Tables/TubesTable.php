<?php

namespace App\Filament\Raddb\Resources\Tubes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TubesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                IconColumn::make('tube_status')
                    ->icon(fn (string $state): Heroicon => match ($state) {
                        'Active' => Heroicon::Check,
                        'Removed' => Heroicon::Trash,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'Active' => 'success',
                        'Removed' => 'danger',
                        default => 'info',
                    }),
                TextColumn::make('machine.description')
                    ->searchable(),
                TextColumn::make('housing_manuf.manufacturer')
                    ->searchable(),
                TextColumn::make('housing_model')
                    ->searchable(),
                TextColumn::make('housing_sn')
                    ->searchable(),
                TextColumn::make('insert_manuf.manufacturer')
                    ->searchable(),
                TextColumn::make('insert_model')
                    ->searchable(),
                TextColumn::make('insert_sn')
                    ->searchable(),
                TextColumn::make('manuf_date')
                    ->date('Y-m-d')
                    ->sortable(),
                TextColumn::make('install_date')
                    ->date('Y-m-d')
                    ->sortable(),
                TextColumn::make('remove_date')
                    ->date('Y-m-d')
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
            ])
            ->groups([
                'machine.description',
            ])
            ->defaultGroup('machine.description')
            ->filters([
                Filter::make('active')
                    ->query(fn (Builder $query): Builder => $query->where('tube_status', 'Active'))
                    ->toggle()
                    ->default(),
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
