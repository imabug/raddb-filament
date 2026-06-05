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
         * Table to store tube information.
         */
        Schema::create('tubes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('machine_id')
                ->comment('Foreign key to machines table')
                ->nullable(false)
                ->index()
                ->constrained(table: 'machines')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->foreignId('housing_manuf_id')
                ->comment('Foreign key to manufacturers table')
                ->nullable()
                ->index()
                ->constrained(table: 'manufacturers')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->tinyText('housing_model')
                ->index()
                ->nullable();
            $table->tinyText('housing_sn')
                ->index()
                ->nullable();
            $table->foreignId('insert_manuf_id')
                ->comment('Foreign key to manufacturers table')
                ->nullable()
                ->index()
                ->constrained(table: 'manufacturers')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->tinyText('insert_model')->index()->nullable();
            $table->tinyText('insert_sn')->index()->nullable();
            $table->date('manuf_date')->index()->nullable();
            $table->date('install_date')->index()->nullable();
            $table->date('remove_date')->index()->nullable();
            $table->decimal('lfs', total:2, places:1)->default('0.0');
            $table->decimal('mfs', total:2, places:1)->default('0.0');
            $table->decimal('sfs', total:2, places:1)->default('0.0');
            $table->string('tube_status', 20)->index();
            $table->text('notes')->nullable()->fulltext();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tubes');
    }
};
