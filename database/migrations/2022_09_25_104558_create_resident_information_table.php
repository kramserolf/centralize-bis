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
            $table->id();
            $table->smallInteger('barangayId');
            $table->string('lastName');
            $table->string('firstName');
            $table->string('middleName')->nullable();
            $table->string('alias')->nullable();
            $table->string('birthday'); 
            $table->smallInteger('age');
            $table->string('civilStatus');
            $table->string('voterStatus');
            $table->string('birthPlace');
            $table->string('mobileNumber');
            $table->string('email')->unique();
            $table->string('spouse')->nullable();
            $table->string('fatherName')->nullable();
            $table->string('motherName')->nullable();
            $table->string('addressOne');
            $table->string('addressTwo')->nullable();
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
