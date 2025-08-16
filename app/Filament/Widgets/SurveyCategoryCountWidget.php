<?php

namespace App\Filament\Widgets;

use App\Models\TestDate;
use App\Models\TestType;
use Filament\Widgets\ChartWidget;

class SurveyCategoryCountWidget extends ChartWidget
{
    protected ?string $heading = 'Survey Categories';
    protected ?string $pollingInterval = null;
    public ?string $filter = '';

    public function getDescription(): ?string
    {
        return 'The number of surveys performed each year by category.  Includes annual and acceptance tests, major service checks, shielding plans and surveys, accreditation surveys.';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'colors' => [
                    'enabled' => "true",
                    'forceOverride' => "true"
                ],
            ],
        ];
    }

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

    protected function getData(): array
    {
        $activeFilter = empty($this->filter) ? date("Y") : $this->filter;

        $categories = TestType::whereNotIn('id', [8, 10])
                          ->orderBy('id')
                          ->get('test_type')
                          ->all();

        foreach ($categories as $c) {
            $categoryLabels[] = $c['test_type'];
        }

        $categoryCounts = TestDate::with('type')
                              ->year($activeFilter)
                              ->whereNotIn('type_id', [8, 10])
                              ->orderBy('type_id')
                              ->get()
                              ->countBy('type_id')
                              ->all();

        foreach ($categoryCounts as $k=>$v) {
            $data[] = $v;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Monthly survey counts',
                    'data' => $data,
                ],
            ],
            'labels' => $categoryLabels,
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
