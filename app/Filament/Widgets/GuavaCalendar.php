<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Guava\Calendar\Filament\CalendarWidget;
use Guava\Calendar\ValueObjects\FetchInfo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class GuavaCalendar extends CalendarWidget
{
    protected string $view = 'filament.widgets.guava-calendar';

    protected function getEvents(FetchInfo $info): Collection|array|Builder
    {
        return [];
    }
}
