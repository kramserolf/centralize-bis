<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resident_information', function (Blueprint $table) {
            $table->id( );
            $table->smallInteger('barangayId');
            $table->smallInteger('household_no')->nullable();
            $table->decimal('family_no')->nullable();
            $table->string('name');
            $table->string('gender');
            $table->string('civil_status');
            $table->date('birthday');
            $table->string('age');
            $table->string('hf_relation')->nullable();
            $table->string('religion')->nullable();
            $table->mediumInteger('zone');
            $table->string('barangay');
            $table->string('municipality');
            $table->string('province');
            $table->string('educational_attainment')->nullable();
            $table->string('eligibilty')->nullable();
            $table->string('osy')->nullable();
            $table->string('reason_osy')->nullable();
            $table->string('literate')->nullable();
            $table->string('special_skill')->nullable();
            $table->string('occupation')->nullable();
            $table->string('employment_nature')->nullable();
            $table->string('work_place')->nullable();
            $table->string('monthly_income')->nullable();
            $table->string('health_condition')->nullable();
            $table->string('sector')->nullable();
            $table->string('disability')->nullable();
            $table->string('benefits')->nullable();
            $table->string('with_electricity')->nullable();
            $table->string('electric_bill')->nullable();
            $table->string('rice_area')->nullable();
            $table->string('rice_location')->nullable();
            $table->string('rice_ownership_status')->nullable();
            $table->string('farm_type')->nullable();
            $table->string('farm_flooded')->nullable();
            $table->string('corn_area')->nullable();
            $table->string('corn_ownership_status')->nullable();
            $table->string('corn_location')->nullable();
            $table->string('flooded')->nullable();
            $table->string('hvc')->nullable();
            $table->string('livestock')->nullable();
            $table->string('poultry')->nullable();
            $table->string('fishery')->nullable();
            $table->string('sanitary_toilet')->nullable();
            $table->string('water_source')->nullable();
            $table->string('motorcycle')->nullable();
            $table->string('tricycle')->nullable();
            $table->string('van')->nullable();
            $table->string('car')->nullable();
            $table->string('truck')->nullable();
            $table->string('kuliglig')->nullable();
            $table->string('ripper')->nullable();
            $table->string('tractor')->nullable();
            $table->string('cellphone')->nullable();
            $table->string('computer')->nullable();
            $table->string('flood_prone')->nullable();
            $table->string('landslide_prone')->nullable();
            $table->string('experience_drought')->nullable();
            $table->string('typhoon_evacuation')->nullable();
            $table->string('living_makeshift')->nullable();
            $table->string('illegal_settlers')->nullable();
            $table->string('malnourish')->nullable();
            $table->string('waste_management')->nullable();
            $table->string('crime_victim')->nullable();
            $table->string('crime_cause')->nullable();
            $table->string('psa_registered')->nullable();
            $table->string('emergency_kit')->nullable();
            $table->string('cp_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resident_information');
    }
};
