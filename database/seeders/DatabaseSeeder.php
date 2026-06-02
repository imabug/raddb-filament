<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run all the seeders
        $this->call([
            FacilitySeeder::class,
            LocationSeeder::class,
            ManufacturerSeeder::class,
            ModalitySeeder::class,
            TestTypeSeeder::class,
        ]);
    }
}
