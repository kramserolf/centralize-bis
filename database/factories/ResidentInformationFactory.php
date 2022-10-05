<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ResidentInformation;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ResidentInformation>
 */
class ResidentInformationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = ResidentInformation::class;

    public function definition()
    {   

        return [
            'barangayId' => 2,
            'family_no' => $this->faker->randomDigit,
          'name' => $this->faker->name,
          'gender' => 'male',
          'civil_status' => $this->faker->text,
            'birthday' => $this->faker->date,
          'age' => $this->faker->randomDigit,
          'hf_relation' => $this->faker->text,
          'religion' => $this->faker->text,
          'zone' => $this->faker->text,
          'barangay' => 'dalin',
          'municipality' => 'baggao',
          'province' => 'cagayan',
          'educational_attainment' => $this->faker->text,
          'eligibilty' => $this->faker->text,
          'osy' => $this->faker->text,
          'reason_osy' => $this->faker->text,
          'literate' => $this->faker->text,
          'special_skill' => $this->faker->text,
          'occupation' => $this->faker->text,
          'employment_nature' => $this->faker->text,
          'work_place' => $this->faker->text,
          'monthly_income' => $this->faker->text,
          'health_condition' => $this->faker->text,
          'sector' => $this->faker->text,
          'disability' => $this->faker->text,
          'benefits' => $this->faker->text,
          'with_electricity' => $this->faker->text,
          'electric_bill' => $this->faker->text,
          'rice_area' => $this->faker->text,
          'rice_location' => $this->faker->text,
          'rice_ownership_status' => $this->faker->text,
          'farm_type' => $this->faker->text,
          'farm_flooded' => $this->faker->text,
          'corn_area' => $this->faker->text,
          'corn_ownership_status' => $this->faker->text,
          'corn_location' => $this->faker->text,
          'flooded' => $this->faker->text,
          'hvc' => $this->faker->text,
          'livestock' => $this->faker->text,
          'poultry' => $this->faker->text,
          'fishery' => $this->faker->text,
          'sanitary_toilet' => $this->faker->text,
          'water_source' => $this->faker->text,
          'motorcycle' => $this->faker->text,
          'tricycle' => $this->faker->text,
          'van' => $this->faker->text,
          'car' => $this->faker->text,
          'truck' => $this->faker->text,
          'kuliglig' => $this->faker->text,
          'ripper' => $this->faker->text,
          'tractor' => $this->faker->text,
          'cellphone' => $this->faker->text,
          'computer' => $this->faker->text,
          'flood_prone' => $this->faker->text,
          'landslide_prone' => $this->faker->text,
          'experience_drought' => $this->faker->text,
          'typhoon_evacuation' => $this->faker->text,
          'living_makeshift' => $this->faker->text,
          'illegal_settlers' => $this->faker->text,
          'malnourish' => $this->faker->text,
          'waste_management' => $this->faker->text,
          'crime_victim' => $this->faker->text,
          'crime_cause' => $this->faker->text,
          'psa_registered' => 'yes',
          'emergency_kit' => $this->faker->text,
          'cp_number' => $this->faker->phoneNumber,
        ];
    }
}
