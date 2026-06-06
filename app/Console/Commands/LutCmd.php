<?php

namespace App\Console\Commands;

use App\Models\Facility;
use App\Models\Location;
use App\Models\Manufacturer;
use App\Models\Modality;
use App\Models\TestType;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\error;
use function Laravel\Prompts\info;
use function Laravel\Prompts\select;
use function Laravel\Prompts\table;
use function Laravel\Prompts\text;

#[Description('Command to manage lookup tables')]
class LutCmd extends Command implements PromptsForMissingInput
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
     * Prompt for missing arguments
     */
    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'cmd' => 'Enter a command to run (add, edit, delete, list)',
            'table' => 'Enter a table to work on',
        ];
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cmd = Str::lower($this->argument('cmd'));
        $table = Str::studly($this->argument('table'));

        switch ($cmd) {
            case 'add':
                info('Adding to ' . $table);
                $this->add($table);
                break;
            case 'edit':
                info('Editing ' . $table);
                $this->edit($table);
                break;
            case 'delete':
                info('Deleting from ' . $table);
                $this->delete($table);
                break;
            case 'list':
                info('Listing ' . $table);
                $this->list($table);
                break;
            default:
                error('Invalid command specified.  Valid commands are: add, delete, edit, list');
                return 1;
                break;
        }
    }

    public function add(string $table): int
    {
        $lut = null;

        // Display the table so the user can see what's already in the table
        $this->list($table);

        switch ($table) {
            case 'Facility':
                $lut = new Facility();
                $lut->facility = text(
                    label: 'Enter a new facility',
                    required: true,
                    validate: fn(string $value) => match (true) {
                        Str::length($value) > 255 => 'Facility name must be less than 255 characters',
                    },
                );
                $lut->street_address = text(
                    label: 'Enter the street address',
                    validate: fn(string $value) => match (true) {
                        Str::length($value) > 255 => 'Facility address must be less than 255 characters',
                        default => null,
                    },
                );
                $lut->city = text(
                    label: 'Enter the city',
                    validate: fn(string $value) => match (true) {
                        Str::length($value) > 255 => 'Facility city must be less than 255 characters',
                        default => null,
                    },
                );
                $lut->state = text(
                    label: 'Enter the state',
                    validate: fn(string $value) => match (true) {
                        Str::length($value) > 255 => 'Facility state must be less than 255 characters',
                        default => null,
                    },
                );
                $lut->zip_code = text(
                    label: 'Enter the zip code',
                    validate: fn(string $value) => match (true) {
                        Str::length($value) > 10 => 'Facility zip code must be less than 10 characters',
                        default => null,
                    },
                );
                break;
            case 'Location':
                $lut = new Location();
                $lut->facility_id = select(
                    label: 'Select a facility for this location',
                    options: Facility::pluck('facility', 'id'),
                    scroll: 10,
                    required: true,
                );
                $lut->location = text(
                    label: 'Enter a new location',
                    required: true,
                    validate: fn(string $value) => match (true) {
                        Str::length($value) > 100 => 'The location must be less than 100 characters',
                        default                   => null,
                    },
                );
                break;
            case 'Manufacturer':
                $lut = new Manufacturer();
                $lut->manufacturer = text(
                    label: 'Enter a new manufacturer',
                    required: true,
                    validate: fn(string $value) => match (true) {
                        Str::length($value) > 50 => 'The manufacturer must be less than 50 characters',
                        default                  => null,
                    },
                );
                break;
            case 'Modality':
                $lut = new Modality();
                $lut->modality = text(
                    label: 'Enter a new modality',
                    required: true,
                    validate: fn(string $value) => match (true) {
                        Str::length($value) > 25 => 'The modality must be less than 50 characters',
                        default                  => null,
                    },
                );
                break;
            case 'Testtype':
                $lut = new TestType();
                $lut->testtype = text(
                    label: 'Enter a new test type',
                    required: true,
                    validate: fn(string $value) => match (true) {
                        Str::length($value) > 30 => 'The test type must be less than 30 characters',
                        default                  => null,
                    },
                );
                break;
            default:
                error('Invalid lookup table given');
                return 1;
                break;
        }

        if (is_object($lut)) {
            // Probably should do some kind of duplicate checking before saving
            $lut->save();
            info('New ' . $table . ' entry saved');
        }

        return 0;
    }

    public function edit(string $table): int
    {
        // Fully qualified model name from the $table provided
        $modelClass = "\App\Models\\" . $table;
        // Attribute in the database table
        $tableAttr = Str::snake($table);
        // Lookup table model instance
        $lut = null;

        // Display the table so the user can see what's in the table
        $this->list($table);

        // Ask which item to edit
        $id = select(
            label: 'Select the ' . $tableAttr . ' to edit',
            options: $modelClass::pluck($tableAttr, 'id'),
            scroll: 10,
        );

        // Retrieve the selected model
        $lut = $modelClass::find($id);

        switch ($tableAttr) {
            case 'facility':
                // Ask the user to edit each facility attribute.
                // Current values are set as the default
                $lut->facility = text(
                    label: 'Enter a new facility name (enter to leave unchanged).',
                    default: $lut->facility,
                    required: true,
                );
                $lut->street_address = text(
                    label: 'Enter a new street address (enter to leave unchanged)',
                    default: $lut->street_address ?? '',
                    required: false,
                );
                $lut->city = text(
                    label: 'Enter a new city (enter to leave uchanged).',
                    default: $lut->city ?? '',
                    required: false,
                );
                $lut->state = text(
                    label: 'Enter a new state (enter to leave unchanged.)',
                    default: $lut->state ?? '',
                    required: false,
                );
                $lut->zip_code = text(
                    label: 'Enter a new zip code (enter to leave unchanged).',
                    default: $lut->zip_code ?? '',
                    required: false,
                );

                // Run the entered data through the validator
                $validator = Validator::make($lut->toArray(), [
                    'facility' => 'required|string|max:255',
                    'street_address' => 'string|max:255',
                    'city' => 'string|max:255',
                    'state' => 'string|max:255',
                    'zip_code' => 'string|max:10',
                ]);

                // Validation failed on something.  Show the errors and exit.
                if ($validator->fails()) {
                    $errors = $validator->errors();
                    foreach ($errors->all() as $message) {
                        error($message);
                    }
                    return 1;
                }

                // Ask for confirmation before saving the model
                if (confirm('Save these changes?')) {
                    $lut->save();
                    info('Changes have been saved.');
                } else {
                    info('No changes made');
                }
                break;
            case 'location':
                // Ask the user to edit each location attribute
                // Current values are set as the default
                $lut->facility_id = select(
                    label: 'Select a new facility for this location (enter to leave unchanged',
                    options: Facility::pluck('facility', 'id'),
                    default: $lut->facility_id,
                    scroll: 10,
                    required: true,
                );
                $lut->location = text(
                    label: 'Enter a new location (enter to leave unchanged).',
                    default: $lut->location,
                    required: true,
                );

                // Ask for confirmation before saving the model
                if (confirm('Save these changes?')) {
                    $lut->save();
                    info('Changes have been saved.');
                } else {
                    info('No changes made.');
                }
                break;
            case 'manufacturer':
            case 'modality':
            case 'testtype':
                // Ask what the new value should be
                $value = text(label: "What should the new value be?", required: true);

                // Confirm the change
                if (confirm(
                    label: 'Changing ' . $lut->$tableAttr . ' to ' . $value . '.',
                    default: false,
                )) {
                    $lut->$tableAttr = $value;
                    $lut->save();
                    // Display the updated table
                    $this->list($table);
                    info($table . ' table ID: ' . $id . ' edited.');
                } else {
                    info('No changes made.');
                }
                break;
            default:
                error('Usage: php artisan raddb:lut edit <table>');
        }

        return 0;
    }

    public function delete(string $table): int
    {
        // Fully qualified model name from the provided $table
        $modelClass = "\App\Models\\" . $table;
        // Attribute in the database table
        $tableAttr = Str::snake($table);
        // Lookup table model instance
        $lut = null;

        // Display the table so the user can select an ID to delete
        $this->list($table);

        // Ask the user to select the ID to remove
        $lut = $modelClass::find(text(label: 'Enter the ID to remove', required: true));

        // Confirm the selection
        if (confirm(
            label: 'Deleting from ' . $table . ' ID: ' . $lut->id . ' Value: ' . $lut->$tableAttr,
            default: false,
        )) {
            $lut->delete();
            info($table . ' ID: ' . $lut->id . ' deleted');
        } else {
            info('No changes made');
        }

        return 0;
    }

    public function list(string $table): int
    {
        // Fully qualified model name from the provided table
        $modelClass = "\App\Models\\" . $table;

        table(
            ['ID', $table],
            $modelClass::all(['id', Str::snake($table)])->toArray(),
        );

        return 0;
    }
}
