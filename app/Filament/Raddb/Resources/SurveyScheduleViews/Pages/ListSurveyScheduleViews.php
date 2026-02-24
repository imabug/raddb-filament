<?php

namespace App\Filament\Raddb\Resources\SurveyScheduleViews\Pages;

use App\Filament\Raddb\Resources\SurveyScheduleViews\SurveyScheduleViewResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListSurveyScheduleViews extends ListRecords
{
    protected static string $resource = SurveyScheduleViewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All'),
            'pending' => Tab::make('Pending')
                             ->modifyQueryUsing(fn(Builder $query) => $query->where('currSurveyDate', '>', now())),
            'needSurvey' => Tab::make('Need to survey')
                               ->modifyQueryUsing(fn(Builder $query) => $query->where('currSurveyDate', null)),
        ];
    }
}
