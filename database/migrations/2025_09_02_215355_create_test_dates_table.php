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
         * Table to store equipment survey dates
         */
        Schema::create('test_dates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('machine_id')
                ->comment('Foreign key to machines table')
                ->nullable(false)
                ->index()
                ->constrained(table: 'machines')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->foreignId('test_type_id')
                ->comment('Foreign key to testtypes table')
                ->nullable(false)
                ->index()
                ->constrained(table: 'test_types')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->dateTime('test_date', precision: 0)->nullable(false)->index();
            $table->string('accession', length:50)->nullable()->index();
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
        Schema::dropIfExists('testdates');
    }
};
