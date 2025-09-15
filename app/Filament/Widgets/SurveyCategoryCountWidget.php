<?php

namespace App\Filament\Widgets;

use App\Models\TestDate;
use App\Models\TestType;
use Filament\Widgets\ChartWidget;

class SurveyCategoryCountWidget extends ChartWidget
{
    /*
     * FilamentPHP widget to display the number of surveys performed each year by
     * test type category.
     */

    protected ?string $heading = 'Survey Categories';
    protected ?string $pollingInterval = null;
    protected static ?int $sort = 3;
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
        // Get a collection of all the survey years in the database
        $years = TestDate::selectRaw('year(test_date) as years')
                     ->distinct()
                     ->orderBy('years', 'desc')
                     ->get()
                     ->all();

        if (count($years) == 0) {
            $yearFilter[] = 0;
        } else {
            foreach ($years as $y) {
                $yearFilter[$y['years']] = $y['years'];
            }
        }

        return $yearFilter;
    }

    protected function getData(): array
    {
        // If $this->filter is empty, set $activeFilter to the current year
        if (empty($this->filter)) {
            $this->filter = date("Y");
        }

        /*
         * Count the surveys for each test type
         * Don't count these survey types:
         * 8 - Other
         * 10 - Calibration
         */
        $categoryCounts = TestDate::with('testtype')
                              ->year($this->filter)
                              ->whereNotIn('testtype_id', [8, 10])
                              ->get()
                              ->countBy('testtype.test_type')
                              ->sortDesc();

        return [
            'datasets' => [
                [
                    'data' => $categoryCounts->flatten(1)->all(),
                ],
            ],
            'labels' => $categoryCounts->keys()->all(),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
