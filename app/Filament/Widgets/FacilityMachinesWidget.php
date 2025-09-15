<?php

namespace App\Filament\Widgets;

use App\Models\Machine;
use Filament\Widgets\ChartWidget;

class FacilityMachinesWidget extends ChartWidget
{
    protected ?string $heading = 'Machine Count by Facility';
    protected ?string $pollingInterval = null;
    protected static ?int $sort = 5;

    public function getDescription(): ?string
    {
        return 'Number of machines at each facility.';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'colors' => [
                    'enabled' => "true",
                    'forceOverride' => "true",
                ],
            ],
        ];
    }

    protected function getData(): array
    {
        $machines = Machine::with('facility')
                        ->active()
                        ->get()
                        ->countBy('facility.facility')
                        ->sort();
        
        return [
            'datasets' => [
                [
                    'data' => $machines->flatten(1)->all(),
                ],
            ],
            'labels' => $machines->keys()->all(),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
