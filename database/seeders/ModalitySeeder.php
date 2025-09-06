<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModalitySeeder extends Seeder
{
    // Array of modalities to seed the modalities table with
    protected $modalities = [
        'Portable',
        'C-Arm',
        'Radiography',
        'Fluoroscopy',
        'Rad/Fluoro',
        'CR reader',
        'CT',
        'Mammography',
        'CR workstation',
        'MRI',
        'Ultrasound',
        'Processor',
        'Cath lab',
        'Angiography',
        'Stereotactic breast biopsy',
        'Nuclear medicine',
        'Dental',
        'Bone density',
        'Test equipment',
        'Mammography workstation',
        'Printer',
        'Dose calibrator',
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->modalities as $m) {
            DB::table('modalities')->insert([
                'modality' => $m,
            ]);
        }
}
