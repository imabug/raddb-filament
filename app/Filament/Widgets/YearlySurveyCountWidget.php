<?php

namespace App\Filament\Widgets;

use App\Models\TestDate;
use Filament\Widgets\ChartWidget;

class YearlySurveyCountWidget extends ChartWidget
{
    protected ?string $heading = 'Yearly Survey Counts';
    protected ?string $pollingInterval = null;
    protected static ?int $sort = 1;

    public function getDescription(): ?string
    {
        return 'The number of surveys performed each year.  Includes annual and acceptance tests, major service checks, shielding plans and surveys, accreditation surveys.';
    }

    protected function getData(): array
    {
        $yearCounts = TestDate::whereNotIn('type_id', [8, 10])
                          ->get()
                          ->countBy(
                              function ($item, $key) {
                                  return substr($item['test_date'], 0, 4);
                              }
                          )
                          ->sortKeys();

        return [
            'datasets' => [
                [
                    'label' => 'Yearly survey counts',
                    'data' => $yearCounts->flatten(),
                ],
            ],
            'labels' => $yearCounts->keys(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
