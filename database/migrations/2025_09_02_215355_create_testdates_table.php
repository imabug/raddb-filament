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
        Schema::create('testdates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('machine_id')->nullable(false);
            $table->foreignId('testtype_id')->nullable(false);
            $table->date('test_date')->nullable(false);
            $table->string('accession', length:50)->nullable();
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
