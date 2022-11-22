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
        Schema::create('blotters', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('barangay_id');
            $table->smallInteger('user_id');
            $table->string('respondents');
            $table->string('incident_type');
            $table->string('status')->default('pending');
            $table->date('schedule_date');
            $table->date('date_reported');
            $table->string('location')->nullable();
            $table->string('narrative');
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
        Schema::dropIfExists('blotters');
    }
};
