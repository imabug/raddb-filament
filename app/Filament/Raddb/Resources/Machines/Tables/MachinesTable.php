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
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Grouping\Group;
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
                TextColumn::make('location.location')
                    ->searchable(),
                TextColumn::make('modality.modality')
                    ->searchable(),
                TextColumn::make('description')
                    ->searchable(),
                TextColumn::make('manufacturer.manufacturer')
                    ->searchable(),
                TextColumn::make('model')
                    ->searchable(),
                TextColumn::make('serial_number')
                    ->searchable(),
                TextColumn::make('vend_site_id')
                    ->searchable(),
                TextColumn::make('room')
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
                TextColumn::make('age')
                    ->sortable(),
            ])
            ->groups([
                Group::make('facility.facility')
                    ->collapsible(),
                Group::make('location.location')
                    ->collapsible(),
                Group::make('modality.modality')
                    ->collapsible(),
                Group::make('manufacturer.manufacturer')
                    ->collapsible(),
            ])
            ->defaultGroup('facility.facility')
            ->filters([
                TrashedFilter::make(),
                Filter::make('active')
                    ->query(fn (Builder $query): Builder => $query->where('machine_status', "Active"))
                    ->toggle()
                    ->default(),
                SelectFilter::make('facility')
                    ->relationship('facility', 'facility'),
                SelectFilter::make('modality')
                    ->relationship('modality', 'modality'),
                SelectFilter::make('manufacturer')
                    ->relationship('manufacturer', 'manufacturer'),
            ])
            ->deferFilters(false)
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
