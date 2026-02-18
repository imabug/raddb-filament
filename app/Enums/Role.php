<?php

namespace App\Enums;

use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;

enum Role: string implements HasLabel
{
    case Staff = 'Staff';
    case PhysAssist = 'Physics Assistant';
    case Resident = 'Resident';
    case FmrResident = 'Former Resident';
    case Technologist = 'Technologist';

    public function getDescription(): ?string
    {
        return match ($this) {
            self::Staff => 'Staff physicist',
            self::PhysAssist => 'Physics assistant',
            self::Resident => 'Resident',
            self::FmrResident => 'Former Resident',
            self::Technologist => 'Technologist'
        };
    }

    public function getLabel(): ?string
    {
        return $this->name;
    }
}
