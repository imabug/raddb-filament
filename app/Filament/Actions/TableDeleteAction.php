<?php

namespace App\Filament\Actions;

use Filament\Actions\DeleteAction;
 
class TableDeleteAction extends DeleteAction
{
    protected function setUp(): void
    {
        parent::setUp();
 
        $this->iconButton();
    }
}
