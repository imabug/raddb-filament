<?php

namespace App\Filament\Admin\Resources\TestTypes\Pages;

use App\Filament\Admin\Resources\TestTypes\TestTypeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTestType extends CreateRecord
{
    protected static string $resource = TestTypeResource::class;
}
