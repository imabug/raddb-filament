<?php

namespace App\Filament\Widgets;

use App\Models\TestDate;
use Filament\Widgets\ChartWidget;

class MonthlySurveyCountWidget extends ChartWidget
{
    protected ?string $heading = 'Monthly Survey Counts';
    protected ?string $pollingInterval = null;
    protected static ?int $sort = 2;
    public ?string $filter = '';

    public function getDescription(): ?string
    {
        return 'The number of surveys performed in each month.  Includes annual and acceptance tests, major service checks, shielding plans and surveys, accreditation surveys.';
    }

    protected function getFilters(): ?array
    {
        // Get a collection of all the survey years in the database
        $years = TestDate::selectRaw('year(test_date) as years')
                     ->distinct()
                     ->orderBy('years', 'desc')
                     ->get()
                     ->all();

        foreach ($years as $y) {
            $yearFilter[$y['years']] = $y['years'];
        }

        return $yearFilter;
    }

    protected function getData(): array
    {
        // If $this->filter is empty, set $activeFilter to the current year
        if (empty($this->filter)) {
            $this->filter = date("Y");
        }

        // Count the surveys for each month of the selected year
        $monthlyCount = TestDate::selectRaw('count(test_date) as c')
                            ->whereRaw('year(test_date)=?', $this->filter)
                            ->groupByRaw('month(test_date)')
                            ->get()
                            ->all();

        foreach ($monthlyCount as $c) {
            $data[] = $c['c'];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Monthly survey counts',
                    'data' => $data,
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
