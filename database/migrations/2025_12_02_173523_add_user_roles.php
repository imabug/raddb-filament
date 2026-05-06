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
        /*
         * Add a role field to the users table.
         * The list of roles is defined in app/enums/Role.php
         */
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 100)
                ->nullable(false)
                ->after('password')
                ->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
