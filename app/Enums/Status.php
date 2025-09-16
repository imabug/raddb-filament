<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;

enum Status: string implements HasColor,HasIcon,HasLabel
{
    case Active = 'Active';
    case Inactive = 'Inactive';
    case Removed = 'Removed';

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Active => 'success',
            self::Inactive => 'warning',
            self::Removed => 'danger'
        };
    }

    public function getDescription(): ? string
    {
        return match ($this) {
            self::Active => 'In use',
            self::Inactive => 'Not in use, but has not been removed yet',
            self::Removed => 'No longer in use and has been removed'
        };
    }
    
    public function getIcon(): ?string
    {
        return match ($this) {
            self::Active => 'heroicon-s-check',
            self::Inactive => 'heroicon-s-x-circle',
            self::Removed => 'heroicon-s-trash'
        };
    }

    public function getLabel(): ?string
    {
        return $this->name;
    }
}
