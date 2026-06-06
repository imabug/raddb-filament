<?php

namespace App\Console\Commands;

use App\Models\Machine;
use App\Models\TestDate;
use App\Models\TestType;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\error;
use function Laravel\Prompts\search;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;
use function Laravel\Prompts\textarea;

#[Description('Command to manage surveys')]
class SurveyCmd extends Command
{
    /**
     * Console command signature
     *
     * @var string
     */
    protected $signature = 'raddb:survey
    {cmd : Command to execute (add, cancel, edit)}
    {id? : Machine or survey ID}';
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cmd = Str::lower($this->argument('cmd'));

        switch ($cmd) {
            case 'add':
                // Adding a new survey.  id argument will be a machine ID.
                if (is_null($this->argument('id'))) {
                    $machine = Machine::find(
                        search(
                            label: 'Search for the machine description to edit',
                            options: fn(string $value) => strlen($value) > 0
                                ? Machine::whereLike('description', '%{$value}%')
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
                $this->add($machine);
                break;
            case 'edit':
                // Editing a survey.  id argument will be a survey ID.
                if (is_null($this->argument('id'))) {
                    $id = text(
                        label: 'Enter a survey ID to edit',
                        validate: fn(int $value) => match (true) {
                            TestDate::find($value) == null => 'Survey ID was not found',
                        },
                        required: true,
                    );
                    $survey = TestDate::find($id);
                } else {
                    $survey = TestDate::find($this->argument('id'));
                }
                $this->edit($survey);
                break;
            case 'cancel':
                // Canceling a survey.  id argument will be a survey ID.
                if (is_null($this->argument('id'))) {
                    $id = text(
                        label: 'Enter a survey ID to cancel',
                        validate: fn(int $value) => match (true) {
                            TestDate::find($value) == null => 'Survey ID was not found',
                        },
                        required: true,
                    );
                    $survey = TestDate::find($id);
                } else {
                    $survey = TestDate::find($this->argument('id'));
                }
                $this->cancel($survey);
                break;
            default:
                info('Usage: php artisan raddb:machine <cmd> <ID?>');
                break;
        }
        //
    }

    protected function add(Machine $machine): int
    {
        // Add new survey
        $survey = new TestDate();

        $survey->machine_id = $machine->id;

        $survey->testtype_id = select(
            label: 'Enter the test type',
            options: TestType::pluck('testtype', 'id'),
            required: true,
        );
        $survey->testdate = text(
            label: 'Enter the test date (YYYY-MM-DD)',
            required: true,
        );
        $survey->accession = text(
            label: 'Enter the accession number',
            validate: fn(string $value) => match (true) {
                strlen($value) > 50 => 'Accession number must be less than 50 characters',
                default => null,
            },
        );
        $survey->notes = text(
            label: 'Enter notes for this test',
            validate: fn(string $value) => match (true) {
                strlen($value) > 65535 => 'Notes must be less than 65535 characters',
                default => null,
            },
        );

        if (confirm('Save this survey?')) {
            $survey->save();
        } else {
            info('Survey was not saved');
        }
        return 0;
    }

    protected function edit(TestDate $survey): int
    {
        info('Editing survey ID' . $survey->id);

        $survey->machine_id = select(
            label: 'Change the machine for this survey',
            options: Machine::pluck('description', 'id'),
            default: $survey->machine_id,
            required: true,
        );
        $survey->testtype_id = select(
            label: 'Change the survey type',
            options: TestType::pluck('testtype', 'id'),
            default: $survey->testtype_id,
            required: true,
        );
        $survey->testdate = text(
            label: 'Change the survey date (YYYY-MM-DD)',
            default: $survey->test_date,
            required: true,
        );
        $survey->accession = text(
            label: 'Change the accession number',
            default: $survey->accession ?? '',
            validate: fn(string $value) => match (true) {
                strlen($value) > 50 => 'Accession number must be less than 50 characters',
                default => null,
            },
        );
        $survey->notes = text(
            label: 'Edit the survey note',
            default: $survey->notes ?? '',
            validate: fn(string $value) => match (true) {
                strlen($value) > 50 => 'Accession number must be less than 50 characters',
                default => null,
            },
        );

        if (confirm('Save these changes?')) {
            $survey->save();
        } else {
            info('Survey changes not saved.');
        }
        return 0;
    }

    protected function cancel(TestDate $survey): int
    {
        info('Cancelling survey ID ' . $survey->id);

        if (confirm(label: 'Cancel survey ID ' . $survey->id . '?')) {
            $survey->delete();
            info('Survey ID ' . $survey->id . ' canceled');
        }
        return 0;
    }
}
