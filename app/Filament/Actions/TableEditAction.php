<?php

namespace App\Filament\Actions;

use Filament\Actions\EditAction;
 
class TableEditAction extends EditAction
{
    protected function setUp(): void
    {
        parent::setUp();
 
        $this->iconButton();
    }
}
