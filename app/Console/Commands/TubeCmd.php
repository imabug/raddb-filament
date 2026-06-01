<?php

namespace App\Console\Commands;

use App\Enums\Status;
use App\Models\Machine;
use App\Models\Manufacturer;
use App\Models\Tube;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\error;
use function Laravel\Prompts\search;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

#[Description('Console command to manage tubes')]
class TubeCmd extends Command
{
    /**
     * Command signature
     * 
     * @var string
     */
    protected $signature = 'raddb:tube 
    {cmd : Command to execute (add, edit, delete)}
    {id? : Machine ID to to add/edit/delete tubes for (optional)}';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cmd = Str::lower($this->argument('cmd'));

        // No id was provided in the argument, so prompt for a machine
        // to operate on
        if (is_null($this->argument('id'))) {
            $machine = Machine::find(
                search(
                    label: 'Search for the machine description to edit',
                    options: fn(string $value) => strlen($value) > 0 ?
                        Machine::whereLike('description', '%{$value}%')
                        ->active()
                        ->orderBy('description')
                        ->pluck('description', 'id')
                        ->all() : []
                )
            );
        } else {
            // Fetch the machine based on the ID provided.
            $machine = Machine::findOrFail($this->argument('id'));
        }

        switch ($cmd) {
            case 'add':
                $this->add($machine);
                break;
            case 'edit':
                $this->edit($machine);
                break;
            case 'delete':
                $this->delete($machine);
                break;
            default:
                info('Usage: php artisan raddb:machine <cmd> <ID?>');
                break;
        }
    }

    public function add(Machine $machine): int
    {
        // Create a new tube model
        $tube = new Tube();
        // Set the tube machine ID
        $tube->machine_id = $machine->id;
        $tube->status = Status::Active;

        // Prompt for tube information
        $tube->housing_manuf_id = select(
            label: 'Select the manufacturer of the tube housing',
            options: Manufacturer::pluck('manufacturer', 'id'),
            scroll: 10
        );
        $tube->housing_model = text(
            label: 'Enter the tube housing model',
            validate: fn(string $value) => match (true) {
                strlen($value) > 255 => 'Model name must be less than 255 characters',
                default => null
            }
        );
        $tube->housing_sn = text(
            label: 'Enter the tube housing serial number',
            validate: fn(string $value) => match (true) {
                strlen($value) > 255 => 'Serial number must be less than 255 characters',
                default => null
            }
        );
        $tube->insert_manuf_id = select(
            label: 'Select the manufacturer of the tube insert',
            options: Manufacturer::pluck('manufacturer', 'id'),
            default: $tube->housing_manuf_id,
            scroll: 10
        );
        $tube->insert_model = text(
            label: 'Enter the tube insert model',
            validate: fn(string $value) => match (true) {
                strlen($value) > 255 => 'Model name must be less than 255 characters',
                default => null
            }
        );
        $tube->insert_sn = text(
            label: 'Enter the tube insert serial number',
            validate: fn(string $value) => match (true) {
                strlen($value) > 255 => 'Serial number must be less than 255 characters',
                default => null
            }
        );
        $tube->manuf_date = text(
            label: 'Enter the tube manufacture date (YYYY-mm-dd)'
        );
        $tube->install_date = text(
            label: 'Enter the tube installation date (YYYY-mm-dd)',
            default: $machine->install_date ?? ''
        );
        $tube->lfs = text(
            label: 'Enter the large focal spot size (mm)',
            validate: fn(float $value) => match (true) {
                is_numeric($value) => 'Large focal spot size must be numeric',
                default => null
            }
        );
        $tube->mfs = text(
            label: 'Enter the medium focal spot size (mm).',
            validate: fn(float $value) => match (true) {
                is_numeric($value) => 'Medium focal spot size must be numeric',
                default => null
            }
        );
        $tube->sfs = text(
            label: 'Enter the small focal spot size (mm)',
            validate: fn(float $value) => match (true) {
                is_numeric($value) => 'Small focal spot size must be numeric',
                default => null
            }
        );
        $tube->notes = text(
            label: 'Enter any notes for the tube',
            validate: fn(string $value) => match (true) {
                strlen($value) > 65535 => 'Notes must be less than 65535 characters',
                default => null
            },
        );

        // Validate some of the input
        $validator = Validator::make($tube->toArray(), [
            'manuf_date' => 'date_format:Y-m-d',
            'install_date' => 'date_format:Y-m-d',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {
                error($message);
            }
            return 1;
        }

        if (confirm(label: 'Save this tube?')) {
            $tube->save();
        } else {
            info('New tube was not saved.');
        }
        return 0;
    }

    public function edit(Machine $machine): int
    {
        // There may be multiple tubes.  Get a list of available tubes
        // and if there is more than 1 tube, ask which one to edit
        $tubes = $machine->tube->where('tube_status', Status::Active);

        if ($tubes->count() > 1) {
            // Multiple tubes available.  Ask which tube to edit
            $tube = Tube::find(
                select(
                    label: 'Select the tube to edit',
                    options: $machine->tube()->pluck('notes', 'id')
                )
            );
        }
        else {
            $tube = $machine->tube()->get();
        }

        $tube->housing_manuf_id = select(
            label: 'Select the manufacturer of the tube housing',
            options: Manufacturer::pluck('manufacturer', 'id'),
            default: $tube->housing_manuf_id ?? '',
            scroll: 10
        );
        $tube->housing_model = text(
            label: 'Enter the tube housing model',
            default: $tube->housing_model ?? '',
            validate: fn(string $value) => match (true) {
                strlen($value) > 255 => 'Model name must be less than 255 characters',
                default => null
            }
        );
        $tube->housing_sn = text(
            label: 'Enter the tube housing serial number',
            default: $tube->housing_sn ?? '',
            validate: fn(string $value) => match (true) {
                strlen($value) > 255 => 'Serial number must be less than 255 characters',
                default => null
            }
        );
        $tube->insert_manuf_id = select(
            label: 'Select the manufacturer of the tube insert',
            options: Manufacturer::pluck('manufacturer', 'id'),
            default: $tube->housing_manuf_id ?? '',
            scroll: 10
        );
        $tube->insert_model = text(
            label: 'Enter the tube insert model',
            default: $tube->insert_model ?? '',
            validate: fn(string $value) => match (true) {
                strlen($value) > 255 => 'Model name must be less than 255 characters',
                default => null
            }
        );
        $tube->insert_sn = text(
            label: 'Enter the tube insert serial number',
            default: $tube->insert_sn ?? '',
            validate: fn(string $value) => match (true) {
                strlen($value) > 255 => 'Serial number must be less than 255 characters',
                default => null
            }
        );
        $tube->manuf_date = text(
            label: 'Enter the tube manufacture date (YYYY-mm-dd)',
            default: $tube->manuf_date ?? ''
        );
        $tube->install_date = text(
            label: 'Enter the tube installation date (YYYY-mm-dd)',
            default: $tube->install_date ?? ''
        );
        $tube->lfs = text(
            label: 'Enter the large focal spot size (mm)',
            default: $tube->lfs ?? '',
            validate: fn(float $value) => match (true) {
                is_numeric($value) => 'Large focal spot size must be numeric',
                default => null
            }
        );
        $tube->mfs = text(
            label: 'Enter the medium focal spot size (mm).',
            default: $tube->mfs ?? '',
            validate: fn(float $value) => match (true) {
                is_numeric($value) => 'Medium focal spot size must be numeric',
                default => null
            }
        );
        $tube->sfs = text(
            label: 'Enter the small focal spot size (mm)',
            default: $tube->sfs ?? '',
            validate: fn(float $value) => match (true) {
                is_numeric($value) => 'Small focal spot size must be numeric',
                default => null
            }
        );
        $tube->notes = text(
            label: 'Enter any notes for the tube',
            default: $tube->notes ?? '',
            validate: fn(string $value) => match (true) {
                strlen($value) > 65535 => 'Notes must be less than 65535 characters',
                default => null
            },
        );
        $tube->tube_status = select(
            label: 'Edit the tube status',
            options: [Status::Active, Status::Inactive, Status::Removed],
            default: $tube->tube_status,
            required: true
        );

        // Validate some of the input
        $validator = Validator::make($tube->toArray(), [
            'manuf_date' => 'date_format:Y-m-d',
            'install_date' => 'date_format:Y-m-d',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {
                error($message);
            }
            return 1;
        }

        if (confirm(label: 'Save these changes?')) {
            $tube->save();
        } else {
            info('No changes were made.');
        }

        return 0;
    }

    public function delete(Machine $machine): int
    {
        info('Deleting tube(s) for ' . $machine->description);

        if (confirm(label: 'This will remove the x-ray tubes for ' . $machine->description . '.  Do you really want to delete this machine')) {
            // Delete any x-ray tubes associated with the machine
            if ($tubes = $machine
                ->tube
                ->where('tube_status', Status::Active)
                ->isNotEmpty()
            ) {
                foreach ($tubes as $tube) {
                    $tube->tube_status = Status::Removed;
                    $tube->remove_date = date('Y-m-d');
                    $tube->save();
                    $tube->delete();
                    info('Tube ID: ' . $tube->id . ' deleted.');
                }
            }
            info('Tubes for ' . $machine->description . ' deleted.');
        }
        return 0;
    }
}
