<?php

test('List table when no arguments are given', function () {
    // Test when no arguments are provided
    $this->artisan('raddb:lut')
        ->expectsQuestion('Enter a command to run (add, edit, delete, list)', 'list')
        ->expectsQuestion('Enter a table to work on', 'facility')
        ->assertExitCode(0);
});
test('List table when only list command is given', function () {
    // Test when no table is provided
    $this->artisan('raddb:lut list')
        ->expectsQuestion('Enter a table to work on', 'facility')
        ->assertExitCode(0);
});

test('List manufacturer table', function () {
    $this->artisan('raddb:lut')
        ->expectsQuestion('Enter a command to run (add, edit, delete, list)', 'list')
        ->expectsQuestion('Enter a table to work on', 'manufacturer')
        ->assertExitCode(0);
});

test('List modality table', function () {
    $this->artisan('raddb:lut')
        ->expectsQuestion('Enter a command to run (add, edit, delete, list)', 'list')
        ->expectsQuestion('Enter a table to work on', 'modality')
        ->assertExitCode(0);
});