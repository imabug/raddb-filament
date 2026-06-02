<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ManufacturerSeeder extends Seeder
{
    /**
     * Array of manufacturers to seed the database with
     * 
     * @var array $manufacturers
     */
    protected $manufacturers = [
        "GE",
        "Acoma",
        "Siemens",
        "Philips",
        "Agfa",
        "Elscint",
        "Lorad",
        "Continental",
        "Gendex",
        "Transworld",
        "Bennett",
        "Transcontinental",
        "Picker",
        "OEC",
        "Panarex",
        "Shimadzu",
        "Hologic",
        "Lunar",
        "Marconi",
        "Trex",
        "Odelft",
        "Unknown",
        "Varian",
        "ADAC",
        "Dynarad",
        "Analogic",
        "Toshiba",
        "Eureka",
        "Dunlee",
        "ThermoKevex",
        "Neurologica",
        "Quantum",
        "Orthoscan",
        "Radcal",
        "RTI Electronics",
        "Sedecal",
        "York",
        "Scanora",
        "Koning",
        "Carestream",
        "Ziehm",
        "Biodex",
        "North American Imaging",
        "Planmeca",
        "Medtronic",
        "Varex",
        "Omega Medical Imaging",
        "Oxford Instruments",
        "Walker Scientific",
        "Barco",
        "XoranTech",
        "Integrity Design & Research",
        "Del Medical",
        "United Imaging",
        "Elekta",
        "CurveBeamAI",
        "Samsung",
        "Hangzhou Kailong",
        "EOS Imaging",
        "Dunlee",
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->manufacturers as $m) {
            DB::table('manufacturers')->insert([
                'manufacturer' => $m,
            ]);
        }
    }
}
