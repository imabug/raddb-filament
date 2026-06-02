<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Array of locations to seed the database with
     * 
     * @var array $locations
     */

    protected $locations = [
        // Inactive facilities
        1 => [
            '30 Bee',
            'CMH',
            'Leeds Ave',
            'Clinical Sciences Building',
            'Module 3',
            'Lowcountry Medical Associates',
            'MUSC Women\'s Health Center',
            'CFC James Island',
            'CFC Mt Pleasant',
            'CFC Carnes Crossroads',
            'GCRC',
            'WA Cardiology Associates',
            'Neuro ICU',
            'Charleston Hand Group',
            'BMET X-ray Repair',
            'MUSC E Cooper Urology',
            'MUSC Children\s After Hours Care North Charleston',
        ],
        // Medical University Hospital
        2 => [
            'Radiology',
            'Pediatric Radiology',
            'OR',
            'Nuclear medicine',
            'Ultrasound',
            'Rutledge Tower',
            'Trauma',
            'Angiography',
            'MRI',
            'CT',
            'Pain Management',
            'University Hospital Extension',
            'Vascular/Interventional Radiology',
            'Neuroradiology',
            'Strom Thurmond Research',
            'Radiology Physics',
            'College of Dental Medicine',
            'WFH',
        ],
        // MUSC Ashley River Tower
        3 => [
            'Radiology',
            'OR',
            'Nuclear medicine',
            'CT',
            'MRI',
            'Cardiology',
            'Vascular Interventional Radiology',
            'Ultrasound',
            'Endoscopy',
        ],
        // MUSC Shawn Jenkins Children's Hospital
        4 => [
            'Radiology',
            'CT',
            'MRI',
            'Emergency department',
            'OR',
            'Ultrasound',
        ],
        // MUSC Health East Cooper
        5 => [
            'Radiology',
            'CT',
            'MRI',
            'Mammography',
            'Nuclear medicine',
        ],
        // MUSC Health West Ashley
        6 => [
            'Radiology',
            'CT',
            'MRI',
            'Mammography',
            'OR',
            'Ultrasound',
            'Pain Management',
        ],
        // MUSC Health North Charleston
        7 => [
            'Radiology',
            'CT',
            'Mammography',
            'Nuclear medicine',
        ],
        // MUSC Health Chuck Dawley
        8 => [
            'Radiology',
            'Pain management',
        ],
        // MUSC Health Clements Ferry
        9 => [
            'Radiology',
            'CT',
            'MRI',
            'Mammography',
        ],
        // MUSC Health Nexton Medical Park
        10 => [
            'Radiology',
            'Pain Management',
        ],
        // Citadel Infirmary
        11 => [
            'Radiology',
        ],
        // MUSC Health Kiawah
        12 => [
            'Radiology',
        ],
        // MUSC Health Summey
        13 => [
            'Radiology',
            'CT',
            'MRI',
            'OR',
        ],
        // MUSC Health AHC Summerville
        14 => [
            'Radiology',
        ],
        // MUSC Health AHC Mt Pleasant
        15 => [
            'Radiology',
        ],
        // MUSC Health AHC Brighton Park
        16 => [
            'Radiology',
        ],
        // MUSC Health Nexton Medical Center
        17 => [
            'Radiology',
            'CT',
            'MRI',
            'OR',
            'Ultrasound',
            'Nuclear medicine',
        ],
        // MUSC Health Nexton Medical Pavilion
        18 => [
            'Radiology',
            'CT',
            'Mammography',
            'Ultrasound',
        ],
        // MUSC Health Hollings Cancer Center
        19 => [
            'Mammography',
            'Radiation Oncology',
        ],
        // MUSC Health HCC Mt Pleasant
        20 => [
            'Radiation Oncology',
        ],
        // MUSC Health HCC Nexton
        21 => [
            'Radiation Oncology',
        ],
    ];
    
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->locations as $facility => $location) {
            foreach ($location as $l) {
                DB::table('locations')->insert(
                    [
                        'facility_id' => $facility,
                        'location' => $l,
                    ]
                );
            }
        }
    }
}
