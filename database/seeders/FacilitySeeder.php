<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacilitySeeder extends Seeder
{
    /**
     * Array of facilities to seed the database with
     * 
     * @var array $facilities
     */

    protected $facilities = [
        'Medical University Hospital' => [
            'street_address' => '169 Ashley Ave',
            'city' => 'Charleston',
            'state' => 'SC',
            'zip_code' => '29425',
        ],
        'MUSC Ashley River Tower' => [
            'street_address' => '25 Courtenay St',
            'city' => 'Charleston',
            'state' => 'SC',
            'zip_code' => '29425',
        ],
        'MUSC Shawn Jenkins Children\'s Hospital' => [
            'street_address' => '10 McClennan Banks Dr',
            'city' => 'Charleston',
            'state' => 'SC',
            'zip_code' => '29425',
        ],
        'MUSC Health East Cooper Medical Pavilion' => [
            'street_address' => '1600 Midtown Ave',
            'city' => 'Mt. Pleasant',
            'state' => 'SC',
            'zip_code' => '27464',
        ],
        'MUSC Health West Ashley Medical Pavilion' => [
            'street_address' => '2060 Sam Rittenberg Blvd',
            'city' => 'Charleston',
            'state' => 'SC',
            'zip_code' => '29407',
        ],
        'MUSC Health North Charleston Medical Pavilion' => [
            'street_address' => '8992 University Blvd',
            'city' => 'North Charleston',
            'state' => 'SC',
            'zip_code' => '29406',
        ],
        'MUSC Health Chuck Dawley Medical Park' => [
            'street_address' => '1106 Chuck Dawley Blvd',
            'city' => 'Mt Pleasant',
            'state' => 'SC',
            'zip_code' => '29464',
        ],
        'MUSC Health Clements Ferry Medical Pavilion' => [
            'street_address' => '1101 Waterline St',
            'city' => 'Charleston',
            'state' => 'SC',
            'zip_code' => '29492',
        ],
        'MUSC Health Nexton Medical Park' => [
            'street_address' => '5500 Front St',
            'city' => 'Summerville',
            'state' => 'SC',
            'zip_code' => '29483',
        ],
        'Citadel Infirmary' => [
            'street_address' => '9 Hammond Ave',
            'city' => 'Charleston',
            'state' => 'SC',
            'zip_code' => '29403',
        ],
        'MUSC Health Kiawah Partners Pavilion' => [
            'street_address' => '1857 Seabrook Island Rd',
            'city' => 'Johns Island',
            'state' => 'SC',
            'zip_code' => '29455',
        ],
        'MUSC Children\'s Health Summey Medical Pavilion' => [
            'street_address' => '2250 Mall Dr',
            'city' => 'North Charleston',
            'state' => 'SC',
            'zip_code' => '29406',
        ],
        'MUSC Children\'s Health After Hours Care Summerville' => [
            'street_address' => '4330 Ladson Rd',
            'city' => 'Ladson',
            'state' => 'SC',
            'zip_code' => '29456',
        ],
        'MUSC Children\'s Health After Hours Care Mt. Pleasant' => [
            'street_address' => '2705 North Hwy 17 Suite 100',
            'city' => 'Mt. Pleasant',
            'state' => 'SC',
            'zip_code' => '29466',
        ],
        'MUSC Children\'s Health After Hours Care Brighton Park' => [
            'street_address' => '322 Brighton Park Blvd',
            'city' => 'Summerville',
            'state' => 'SC',
            'zip_code' => '29483',
        ],
        'MUSC Health Nexton Medical Center' => [
            'street_address' => '1850 Nexton Parkway',
            'city' => 'Summerville',
            'state' => 'SC',
            'zip_code' => '29486',
        ],
        'MUSC Health Nexton Medical Pavilion' => [
            'street_address' => '636 Wellness Way',
            'city' => 'Summerville',
            'state' => 'SC',
            'zip_code' => '29486',
        ],
        'MUSC Health Hollings Cancer Center' => [
            'street_address' => '86 Jonathan Lucas St',
            'city' => 'Charleston',
            'state' => 'SC',
            'zip_code' => '29425',
        ],
        'MUSC Health Hollings Cancer Center Mt. Pleasant' => [
            'street_address' => '1180 Hospital Dr',
            'city' => 'Mt. Pleasant',
            'state' => 'SC',
            'zip_code' => '29464',
        ],
        'MUSC Health Hollings Cancer Center Nexton' => [
            'street_address' => '1852 Nexton Parkway',
            'city' => 'Summerville',
            'state' => 'SC',
            'zip_code' => '29486',
        ],
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->facilities as $facility => $address) {
            DB::table('facilities')->insert(
                [
                    'facility' => $facility,
                    'street_address' => $address['street_address'],
                    'city' => $address['city'],
                    'state' => $address['state'],
                    'zip_code' => $address['zip_code'],
                ]
            );
        }
    }
}
