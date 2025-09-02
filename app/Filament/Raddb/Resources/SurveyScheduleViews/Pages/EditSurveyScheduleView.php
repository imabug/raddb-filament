<?php

namespace App\Filament\Raddb\Resources\SurveyScheduleViews\Pages;

use App\Filament\Raddb\Resources\SurveyScheduleViews\SurveyScheduleViewResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSurveyScheduleView extends EditRecord
{
    protected static string $resource = SurveyScheduleViewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
