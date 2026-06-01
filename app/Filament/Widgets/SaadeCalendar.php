<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class SaadeCalendar extends FullCalendarWidget
{
    public function fetchEvents(array $fetchInfo): array
    {
        return [];
    }
}
