<?php

namespace App\Console\Commands;

use App\Enums\Status;
use App\Models\Facility;
use App\Models\Location;
use App\Models\Machine;
use App\Models\Manufacturer;
use App\Models\Modality;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\error;
use function Laravel\Prompts\search;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;
use function Laravel\Prompts\textarea;

#[Description('Console command to manage machines')]
class MachineCmd extends Command
{
    /**
     * Command signature
     *
     * @var string
     */
    protected $signature = 'raddb:machine 
    {cmd : Command to execute (add, edit, delete)}
    {id? : Machine ID to perform the command on (optional)}';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cmd = Str::lower($this->argument('cmd'));

        // If the command is edit or delete, we need to ask what machine
        // to operate on.  If the command is add, no ID argument is needed.
        if ($cmd != 'add') {
            // No id was provided in the argument, so prompt for a machine
            // to operate on
            if (is_null($this->argument('id'))) {
                $machine = Machine::find(
                    search(
                        label: 'Search for the machine to work on',
                        options: fn(string $value) => strlen($value) > 0
                            ? Machine::whereLike('description', '%' . $value . '%')
                            ->active()
                            ->orderBy('description')
                            ->pluck('description', 'id')
                            ->all() : [],
                    ),
                );
            } else {
                // Fetch the machine based on the ID provided.
                $machine = Machine::findOrFail($this->argument('id'));
            }
        }

        switch ($cmd) {
            case 'add':
                $this->add();
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

    /**
     * Add a new machine
     */
    protected function add(): int
    {
        // Create a new Machine model instance
        $machine = new Machine();

        // Prompt for machine information
        $machine->facility_id = select(
            label: 'Select the facility where this machine is located',
            options: Facility::pluck('facility', 'id'),
            scroll: 10,
            required: true,
        );
        $machine->location_id = select(
            label: 'Select the location in the facility',
            options: Location::where('facility_id', '=', $machine->facility_id)
            ->pluck('location', 'id'),
            scroll: 10,
            required: true,
        );
        $machine->description = text(
            label: 'Give a descriptive name for the machine',
            validate: fn(string $value) => match (true) {
                strlen($value) > 255 => 'Description must be less than 255 characters',
                default => null,
            },
            required: true,
        );
        $machine->modality_id = select(
            label: 'Select a modality for this machine',
            options: Modality::pluck('modality', 'id'),
            scroll: 10,
            required: true,
        );
        $machine->manufacturer_id = select(
            label: 'Select the manufacturer of the machine',
            options: Manufacturer::pluck('manufacturer', 'id'),
            scroll: 10,
            required: true,
        );
        $machine->model = text(
            label: 'Enter the model name of the machine',
            validate: fn(string $value) => match (true) {
                strlen($value) > 255 => 'Model name must be less than 255 characters',
                default => null,
            },
        );
        $machine->serial_number = text(
            label: 'Enter the serial number of the machine',
            validate: fn(string $value) => match (true) {
                strlen($value) > 255 => 'Serial number must be less than 255 characters',
                default => null,
            },
            required: true,
        );
        $machine->vend_site_id = text(
            label: 'Enter the vendor site ID for the machine',
            validate: fn(string $value) => match (true) {
                strlen($value) > 255 => 'Vendor site ID must be less than 255 characters',
                default => null,
            },
            default: $machine->serial_number,
        );
        $machine->room = text(
            label: 'Enter the room number for the machine',
            validate: fn(string $value) => match (true) {
                strlen($value) > 20 => 'Room must be less than 20 characters',
                default => null,
            },
            required: true,
        );
        $machine->manuf_date = text(
            label: 'Enter the manufacture date of the machine (YYYY-MM-DD)',
        );
        $machine->install_date = text(
            label: 'Enter the installation date for the machine (YYYY-MM-DD)',
        );
        $machine->software_version = text(
            label: 'Enter the machine software version',
            validate: fn(string $value) => match (true) {
                strlen($value) > 50 => 'Software version must be less than 50 characters',
                default => null,
            },
        );
        $machine->pacs_station = text(
            label: 'Enter the PACS station name for the machine',
            validate: fn(string $value) => match (true) {
                strlen($value) > 50 => 'PACS station must be less than 50 characters',
                default => null,
            },
        );
        $machine->notes = textarea(
            label: 'Enter any special notes for the  machine',
            validate: fn(string $value) => match (true) {
                strlen($value) > 65535 => 'Notes must be less than 65535 characters',
                default => null,
            },
        );
        $machine->machine_status = Status::Active;

        // Validate some of the fields
        $validator = Validator::make($machine->toArray(), [
            'manuf_date' => 'date_format:y-m-d',
            'install_date' => 'date_format:y-m-d',

        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {
                error($message);
            }
            return 1;
        }

        if (confirm(label: 'Save this new machine?')) {
            // Save the machine
            $machine->save();
            // Check to see if the an x-ray tube needs to be added
            // for the machine.  If the modality_id is not in the
            // array, then it's an x-ray modality.
            // These modality IDs will need to be changed if the
            // modalities table ever gets rearranged.
            if (!in_array($machine->modality_id, [6, 9, 10, 11, 12, 19, 21, 22])) {
                $this->call('raddb:tube add', ['id' => $machine->id]);
            }
        } else {
            info('New machine not saved');
        }
        return 0;
    }

    protected function edit(Machine $machine): int
    {
        info('Editing ' . $machine->description);

        // Prompt to edit each machine attribute
        // Existing values are used as defaults
        $machine->facility_id = select(
            label: 'Select a new facility for the machine',
            options: Facility::pluck('facility', 'id'),
            default: $machine->facility_id,
            required: true,
            scroll: 10,
        );
        $machine->location_id = select(
            label: 'Select the location in the facility',
            options: Location::where('facility_id', '=', $machine->facility_id)
                ->pluck('location', 'id'),
            default: $machine->location_id,
            scroll: 10,
            required: true,
        );
        $machine->description = text(
            label: 'Enter a new description for the machine',
            default: $machine->description,
            required: true,
        );
        $machine->modality_id = select(
            label: 'Select a modality for this machine',
            options: Modality::pluck('modality', 'id'),
            default: $machine->modality_id,
            scroll: 10,
            required: true,
        );
        $machine->manufacturer_id = select(
            label: 'Select the manufacturer of the machine',
            options: Manufacturer::pluck('manufacturer', 'id'),
            default: $machine->manufacturer_id,
            scroll: 10,
            required: true,
        );
        $machine->model = text(
            label: 'Enter the model name of the machine',
            default: $machine->model ?? '',
            validate: fn(string $value) => match (true) {
                strlen($value) > 255 => 'Model name must be less than 255 characters',
                default => null,
            },
        );
        $machine->serial_number = text(
            label: 'Enter the serial number of the machine',
            default: $machine->serial_number ?? '',
            validate: fn(string $value) => match (true) {
                strlen($value) > 255 => 'Serial number must be less than 255 characters',
                default => null,
            },
            required: true,
        );
        $machine->vend_site_id = text(
            label: 'Enter the vendor site ID for the machine',
            default: $machine->vend_site_id ?? '',
            validate: fn(string $value) => match (true) {
                strlen($value) > 255 => 'Vendor site ID must be less than 255 characters',
                default => null,
            },
        );
        $machine->room = text(
            label: 'Enter the room number for the machine',
            default: $machine->room,
            validate: fn(string $value) => match (true) {
                strlen($value) > 20 => 'Room must be less than 20 characters',
                default => null,
            },
            required: true,
        );
        $machine->manuf_date = text(
            label: 'Enter the manufacture date of the machine (YYYY-MM-DD)',
            default: $machine->manuf_date ?? '',
        );
        $machine->install_date = text(
            label: 'Enter the installation date for the machine (YYYY-MM-DD)',
            default: $machine->install_date ?? '',
        );
        $machine->software_version = text(
            label: 'Enter the machine software version',
            default: $machine->software_version ?? '',
            validate: fn(string $value) => match (true) {
                strlen($value) > 50 => 'Software version must be less than 50 characters',
                default => null,
            },
        );
        $machine->pacs_station = text(
            label: 'Enter the PACS station name for the machine',
            default: $machine->pacs_station ?? '',
            validate: fn(string $value) => match (true) {
                strlen($value) > 50 => 'PACS station must be less than 50 characters',
                default => null,
            },
        );
        $machine->notes = textarea(
            label: 'Enter any special notes for the  machine',
            default: $machine->notes ?? '',
            validate: fn(string $value) => match (true) {
                strlen($value) > 65535 => 'Notes must be less than 65535 characters',
                default => null,
            },
        );
        $machine->machine_status = select(
            label: 'Edit the machine status',
            options: [Status::Active, Status::Inactive, Status::Removed],
            default: $machine->machine_status,
            required: true,
        );

        // Validate some of the fields
        $validator = Validator::make($machine->toArray(), [
            'manuf_date' => 'date_format:y-m-d',
            'install_date' => 'date_format:y-m-d',

        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {
                error($message);
            }
            return 1;
        }

        if (confirm(label: 'Save this new machine?')) {
            // Save the machine
            $machine->save();
        } else {
            info('No changes made');
        }

        return 0;
    }

    protected function delete(Machine $machine): int
    {
        info('Deleting ' . $machine->description);

        if (confirm(label: 'This will remove the machine and associated x-ray tubes.  Do you really want to delete this machine')) {
            $machine->machine_status = Status::Removed;
            $machine->remove_date = date('Y-m-d');
            $machine->save();
            // Delete any x-ray tubes associated with the machine
            if ($tubes = $machine
                            ->tube
                            ->where('tube_status', Status::Active)
                            ->isNotEmpty()) {
                foreach ($tubes as $tube) {
                    $tube->tube_status = Status::Removed;
                    $tube->remove_date = date('Y-m-d');
                    $tube->save();
                    $tube->delete();
                    info('Tube ID: ' . $tube->id . ' deleted.');
                }
            }
            $machine->delete();
            info('Machine ' . $machine->description . 'ID: ' . $machine->id . ' deleted.');
        }
        return 0;
    }
}
