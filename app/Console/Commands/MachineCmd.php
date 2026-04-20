<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:machine-cmd')]
#[Description('Command description')]
class MachineCmd extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
