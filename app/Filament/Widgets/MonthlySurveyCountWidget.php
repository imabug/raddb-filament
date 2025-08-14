<?php

namespace App\Filament\Widgets;

use App\Models\TestDate;
use Filament\Forms\Components\Select;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class MonthlySurveyCountWidget extends ChartWidget
{
    protected ?string $heading = 'Monthly Survey Count Widget';
    protected ?string $pollingInterval = null;

    public function getDescription(): ?string
    {
        return 'The number of surveys performed in each month.  Includes annual and acceptance tests, major service checks, shielding plans and surveys, accreditation surveys.';
    }

    protected function getData(): array
    {
        return [
            //
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
