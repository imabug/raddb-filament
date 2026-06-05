<?php

test('console command', function () {
    // Test when no arguments are provided
    $this->artisan('raddb:lut')
        ->expectsQuestion('Enter a command to run (add, edit, delete, list)', 'list')
        ->expectsQuestion('Enter a table to work on', 'list')
        ->assertExitCode(0);

    $this->artisan('raddb:lut list')
        ->expectsQuestion('Enter a table to work on', 'facility')
        ->assertExitCode(0);
});
