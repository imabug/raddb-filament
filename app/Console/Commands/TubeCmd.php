<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('raddb:tube-cmd')]
#[Description('Command description')]
class TubeCmd extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
