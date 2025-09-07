<?php

namespace App\Filament\Admin\Resources\TestTypes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TestTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('test_type')
                    ->required(),
            ]);
    }
}
