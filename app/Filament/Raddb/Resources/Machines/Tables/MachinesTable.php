<?php

namespace App\Filament\Raddb\Resources\Machines\Tables;

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

class MachinesTable
{
    public static function configure(Table $table): Table
    {
        return $table
                   ->columns([
                       IconColumn::make('machine_status')
                           ->icon(fn (string $state): Heroicon => match ($state) {
                               'Active' => Heroicon::Check,
                               'Inactive' => Heroicon::XCircle,
                               'Removed' => Heroicon::Trash,
                       })
                           ->color(fn (string $state): string => match ($state) {
                               'Active' => 'success',
                               'Inactive' => 'warning',
                               'Removed' => 'danger',
                               default => 'info',
                       }),
                       TextColumn::make('description')
                           ->searchable(),
                       TextColumn::make('manufacturer.manufacturer')
                           ->searchable(),
                       TextColumn::make('model')
                           ->searchable(),
                       TextColumn::make('serial_number')
                           ->searchable(),
                       TextColumn::make('modality.modality')
                           ->searchable(),
                       TextColumn::make('vend_site_id')
                           ->searchable(),
                       TextColumn::make('location.location')
                           ->searchable(),
                       TextColumn::make('room')
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
                       TextColumn::make('pacs_station')
                           ->searchable(),
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
                       TextColumn::make('software_version')
                           ->searchable(),
                   ])
                   ->filters([
                       TrashedFilter::make(),
                       Filter::make('active')
                           ->query(fn (Builder $query): Builder => $query->where('machine_status', "Active"))
                           ->toggle()
                           ->default(),
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
