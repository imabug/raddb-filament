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
        Schema::create('testedby', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->nullable(false)
                ->index()
                ->constrained(table: 'users')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->foreignId('survey_id')
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
