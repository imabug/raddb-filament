<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /*
         * Facilities table.
         * The facilities table is intended to store information on
         * facilities where equipment is located.
         * An example of a facility would be a hospital building or
         * stand-alone clinic building that would be considered
         * an organizationally distinct entity.
         */
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->string('facility', 100)->nullable(false);
            $table->string('street_address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip_code', 10)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        /*
         * Locations table
         * The locations table stores locations within a single facility where
         * equipment is located.
         * Departments within a facility, such as a Radiology, or Cardiology
         * department would be examples of locations.
         */
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('facility_id')
                ->nullable(false)
                ->constrained(table: 'facilities')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->string('location', 100)->nullable(false);
            $table->softDeletes();
            $table->timestamps();
        });

        /*
         * Modalities table
         * Stores modalities associated with each machine (i.e. Radiography, CT, etc)
         */
        Schema::create('modalities', function (Blueprint $table) {
            $table->id();
            $table->string('modality', 50)->nullable(false);
            $table->softDeletes();
            $table->timestamps();
        });

        /*
         * Manufacturers table
         * Stores equipment manufacturer names
         */
        Schema::create('manufacturers', function (Blueprint $table) {
            $table->id();
            $table->string('manufacturer', 50)->nullable(false);
            $table->softDeletes();
            $table->timestamps();
        });

        /*
         * Testtypes table
         * Stores types of testing performed (routine, acceptance, etc)
         */
        Schema::create('testtypes', function (Blueprint $table) {
            $table->id();
            $table->string('test_type', 30)->nullable(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facilities');
    }
};
