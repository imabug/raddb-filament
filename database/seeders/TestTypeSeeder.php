<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestTypeSeeder extends Seeder
{
    /**
     * Array of test types to seed the database with
     * 
     * @var array $testTypes
     */
    protected $testTypes = [
        'Routine Compliance',
        'Acceptance',
        'Major service check',
        'Follow up',
        'Phantom review',
        'Shielding survey',
        'Bone densitometer survey',
        'Other',
        'Accreditation survey',
        'Calibration',
        'Shielding plan',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->testTypes as $t) {
            DB::table('test_types')->insert([
                'test_type' => $t,
            ]);
        }
    }
}
