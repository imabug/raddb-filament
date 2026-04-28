<?php

namespace App\Filament\Raddb\Resources\OpNotes\Tables;

use App\Enums\Status;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OpNotesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('note')
                    ->searchable(),
            ])
            ->groups([
                Group::make('machine.description')
                    ->collapsible(),
            ])
            ->defaultGroup('machine.description')
            ->filters([
                TrashedFilter::make(),
                Filter::make('active')
                    ->query(fn(builder $query): Builder => $query->active())
                    // ->query(fn(Builder $query): Builder => $query->with('machine')->where('machine.machine_status', Status::Active))
                    ->toggle()
                    ->default(),
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
