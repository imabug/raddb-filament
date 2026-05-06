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
         * Table to store machine information
         */
        Schema::create('machines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('facility_id')
                ->comment('Foreign key to facilities table')
                ->nullable(false)
                ->index()
                ->constrained(table: 'facilities')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->foreignId('location_id')
                ->comment('Foreign key to locations table')
                ->nullable(false)
                ->index()
                ->constrained(table: 'locations')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->foreignId('manufacturer_id')
                ->comment('Foreign key to manufacturers table')
                ->nullable(false)
                ->index()
                ->constrained(table: 'manufacturers')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->foreignId('modality_id')
                ->commment('Foreign key to modalities table')
                ->nullable(false)
                ->index()
                ->constrained(table: 'modalities')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->tinyText('description')
                ->comment('Commonly understood unit identifier')
                ->nullable()
                ->index();
            $table->tinyText('model')->nullable()->index();
            $table->tinyText('serial_number')->nullable();
            $table->tinyText('vend_site_id')->nullable();
            $table->string('room', length:20)->nullable();
            $table->date('install_date')->index()->nullable();
            $table->date('manuf_date')->index()->nullable();
            $table->date('remove_date')->index()->nullable();
            $table->string('machine_status', 20)
                ->nullable(false)
                ->index();
            $table->string('software_version', length:50)->nullable();
            $table->string('pacs_station', length:50)->nullable();
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('machines');
    }
};
