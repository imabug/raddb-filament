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
        Schema::create('tubes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('machine_id')->nullable(false)->index();
            $table->foreignId('housing_manuf_id')->nullable()->index();
            $table->string('housing_model', length:50)->nullable();
            $table->string('housing_sn', length:20)->nullable();
            $table->foreignId('insert_manuf_id')->nullable()->index();
            $table->string('insert_model', length:50)->nullable();
            $table->string('insert_sn', length:20)->nullable();
            $table->date('manuf_date')->nullable();
            $table->date('install_date')->nullable();
            $table->date('remove_date')->nullable();
            $table->decimal('lfs', total:2, places:1)->default('0.0');
            $table->decimal('mfs', total:2, places:1)->default('0.0');
            $table->decimal('sfs', total:2, places:1)->default('0.0');
            $table->enum('tube_status', ['Active', 'Removed'])->index();
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
        Schema::dropIfExists('tubes');
    }
};
