<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class dummyAccount extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('accounts')->insert([
        //     'barangayId' => 1,
        //     'barangaySecretary' => 'Mark Flores',
        //     'email' => 'kserolf5@gmail.com',
        //     'password' => Hash::make('12345678'),
        //     'contactNumber' => '09350672557',
        // ]);

        // DB::table('resident_information')->insert([
        //     'barangayId' => 2,
        //     'lastName' => 'sdasd',
        //     'firstName' => 'das',
        //     'middleName' => 'D.',
        //     'birthday' => '1994-02-13',
        //     'age' => 28,
        //     'civilStatus' => 'Married',
        //     'voterStatus' => 'Yes',
        //     'birthPlace' => 'Manila',
        //     'mobileNumber' => '09958957832',
        //     'email' => 'sdasa@gmail.com',
        //     'fatherName' => 'Garp Monkey',
        //     'addressOne' => 'San Jose, Baggao, Cagayan',
        // ]);

        DB::table('barangay_officials')->insert(
            [
            'barangay_id' => 2,
            'position' => 'Barangay Captain',
            'name' => 'Roy Gardner',
            'official_committee' => 'Head',
            'year_of_service' => '3 years',
            ],
            [
            'barangay_id' => 2,
            'position' => 'Barangay Secretary',
            'name' => 'Juan Dela Cruz',
            'official_committee' => 'Documents',
            'year_of_service' => '2 years',
            ],
            [
            'barangay_id' => 2,
            'position' => 'Barangay Treasurer',
            'name' => 'Sydney Fox',
            'official_committee' => 'Finance',
            'year_of_service' => '4 years',
            ],
            [
            'barangay_id' => 6,
            'position' => 'Barangay Treasurer',
            'name' => 'Ralph Jordan',
            'official_committee' => 'Finance',
            'year_of_service' => '6 years',
            ],
            [
            'barangay_id' => 6,
            'position' => 'Barangay Secretary',
            'name' => 'Rika Pattung',
            'official_committee' => 'Community Engagement',
            'year_of_service' => '1 year',
            ],
            [
            'barangay_id' => 6,
            'position' => 'Barangay Captain',
            'name' => 'Alanna Hoffman',
            'official_committee' => 'Head',
            'year_of_service' => '8 years',
            ],

        );
    }
}
