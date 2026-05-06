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
         * Table to track who participated in surveys
         */
        Schema::create('testedby', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->comment('Foreign key to users table')
                ->nullable(false)
                ->index()
                ->constrained(table: 'users')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->foreignId('survey_id')
                ->comment('Foreign key to testdates table')
                ->nullable(false)
                ->index()
                ->constrained(table: 'testdates')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testedby');
    }
};
