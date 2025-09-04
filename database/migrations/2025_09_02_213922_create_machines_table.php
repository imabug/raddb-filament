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
        Schema::create('machines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('facility_id')->nullable(false)->index();
            $table->foreignId('location_id')->nullable(false)->index();
            $table->foreignId('manufacturer_id')->nullable(false)->index();
            $table->foreignId('modality_id')->nullable(false)->index();
            $table->string('description', length:100)->nullable();
            $table->string('model', length:100)->nullable();
            $table->string('serial_number', length:50)->nullable();
            $table->string('vend_site_id', length:25)->nullable();
            $table->string('room', length:20)->nullable();
            $table->date('install_date')->nullable();
            $table->date('manuf_date')->nullable();
            $table->date('remove_date')->nullable();
            $table->enum('machine_status', ['Active', 'Inactive', 'Removed'])
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
