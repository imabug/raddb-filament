<?php

namespace App\Filament\Widgets;

use App\Models\Machine;
use Filament\Widgets\ChartWidget;

class MachinesWidget extends ChartWidget
{
    protected ?string $heading = 'Machine Count by Modality';
    protected ?string $pollingInterval = null;
    protected static ?int $sort = 4;

    public function getDescription(): ?string
    {
        return 'Count of active machines by modality.';
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
        $machines = Machine::with('modality')
                        ->get()
                        ->countBy('modality.modality')
                        ->sortDesc();

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
