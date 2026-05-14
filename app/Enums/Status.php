<?php

namespace App\Enums;

use BackedEnum;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;

enum Status: string implements HasColor, HasDescription, HasIcon, HasLabel
{
    case Active = 'Active';
    case Inactive = 'Inactive';
    case Removed = 'Removed';
    case InProgress = 'In progress';
    case NeedInfo = 'Need info';
    case Complete = 'Complete';

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Active => 'success',
            self::Inactive => 'warning',
            self::Removed => 'danger',
            self::InProgress => 'info',
            self::NeedInfo => 'warning',
            self::Complete => 'success',
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::Active => 'In use',
            self::Inactive => 'Not in use, but has not been removed yet',
            self::Removed => 'No longer in use and has been removed',
            self::InProgress => 'In progress',
            self::NeedInfo => 'Awaiting additional information',
            self::Complete => 'Complete'
        };
    }

    public function getIcon(): string|BackedEnum
    {
        return match ($this) {
            self::Active => Heroicon::Check,
            self::Inactive => Heroicon::XCircle,
            self::Removed => Heroicon::Trash,
            self::InProgress => Heroicon::Document,
            self::NeedInfo => Heroicon::InformationCircle,
            self::Complete => Heroicon::DocumentCheck,
        };
    }

    public function getLabel(): ?string
    {
        return $this->name;
    }
}
