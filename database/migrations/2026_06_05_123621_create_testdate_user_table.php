<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /**
         * Many-many relationship table (pivot table) to connect
         * surveys to users.
         */
        Schema::create('testdate_user', function (Blueprint $table) {
            $tablle->id();
            $table->foreignId('testdate_id')
                ->unsigned()
                ->nullable(false)
                ->index()
                ->constrained(table: 'testdates')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->foreignId('user_id')
                ->unsigned()
                ->nullable(false)
                ->index()
                ->constrained(table: 'users')
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testdate_user');
    }
};
