<?php

namespace App\Console\Commands;

use App\Models\Location;
use App\Models\Manufacturer;
use App\Models\Modality;
use App\Models\Tester;
use App\Models\TestType;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

use function Laravel\Prompts\error;
use function Laravel\Prompts\info;
use function Laravel\Prompts\text;

#[Description('Command to manage lookup tables')]
class LutCmd extends Command
{
    /**
     * Console command signature
     *
     * @var string
     */
    protected $signature = 'raddb:lut
{cmd : Command to execute (add, delete, edit, or list)}
{table : Lookup table to manage}';
    
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cmd = $this->argument('cmd');
        $table = $this->argument('table');

        switch ($cmd) {
            case 'add':
                break;
            case 'ediit':
                break;
            case 'delete':
                break;
            case 'list':
                break;
            default:
                $this->error('Invalid command specified.  Valid commands are: add, delete, edit, list');
                return 1;
                break;
        }
    }
}
