<?php

namespace App\Filament\Raddb\Resources\SurveyScheduleViews\Pages;

use App\Filament\Raddb\Resources\SurveyScheduleViews\SurveyScheduleViewResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSurveyScheduleViews extends ListRecords
{
    protected static string $resource = SurveyScheduleViewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
