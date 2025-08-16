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
    public ?string $filter = '';

    protected function getFilters(): ?array
    {
        $years = TestDate::selectRaw('year(test_date) as years')
                     ->distinct()
                     ->orderBy('years','desc')
                     ->get()
                     ->all();

        foreach ($years as $y) {
            $yearFilter[$y['years']] = $y['years'];
        }

        return $yearFilter;
    }

    public function getDescription(): ?string
    {
        return 'The number of surveys performed in each month.  Includes annual and acceptance tests, major service checks, shielding plans and surveys, accreditation surveys.';
    }

    protected function getData(): array
    {
        $activeFilter = empty($this->filter) ? date("Y") : $this->filter;

        $monthlyCount = TestDate::selectRaw('count(test_date) as c')
                            ->whereRaw('year(test_date)=?', $activeFilter)
                            ->groupByRaw('month(test_date)')
                            ->get()
                            ->all();

        foreach ($monthlyCount as $c) {
            $chartData[] = $c['c'];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Monthly survey counts',
                    'data' => $chartData,
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
