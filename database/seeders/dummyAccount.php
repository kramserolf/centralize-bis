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
        DB::table('accounts')->insert([
            'barangayId' => 1,
            'barangaySecretary' => 'Mark Flores',
            'email' => 'kserolf5@gmail.com',
            'password' => Hash::make('12345678'),
            'contactNumber' => '09350672557',
        ]);
    }
}
