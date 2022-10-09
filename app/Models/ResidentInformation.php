<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResidentInformation extends Model
{
    use HasFactory;
    protected $fillable = [ 
            'barangayId',
            'household_no',
            'family_no',
          'name',
          'gender',
          'civil_status',
            'birthday',
          'age',
          'hf_relation',
          'religion',
          'zone',
          'barangay',
          'municipality',
          'province',
          'educational_attainment',
          'eligibilty',
          'osy',
          'reason_osy',
          'literate',
          'special_skill',
          'occupation',
          'employment_nature',
          'work_place',
          'monthly_income',
          'health_condition',
          'sector',
          'disability',
          'benefits',
          'with_electricity',
          'electric_bill',
          'rice_area',
          'rice_location',
          'rice_ownership_status',
          'farm_type',
          'farm_flooded',
          'corn_area',
          'corn_ownership_status',
          'corn_location',
          'flooded',
          'hvc',
          'livestock',
          'poultry',
          'fishery',
          'sanitary_toilet',
          'water_source',
          'motorcycle',
          'tricycle',
          'van',
          'car',
          'truck',
          'kuliglig',
          'ripper',
          'tractor',
          'cellphone',
          'computer',
          'flood_prone',
          'landslide_prone',
          'experience_drought',
          'typhoon_evacuation',
          'living_makeshift',
          'illegal_settlers',
          'malnourish',
          'waste_management',
          'crime_victim',
          'crime_cause',
          'psa_registered',
          'emergency_kit',
          'cp_number',
    ];

}
