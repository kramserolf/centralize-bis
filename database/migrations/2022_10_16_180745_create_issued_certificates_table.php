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
        Schema::create('issued_certificates', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('barangay_id');
            $table->smallInteger('resident_id');
            $table->smallInteger('certificate_typeId');
            $table->smallInteger('certificate_LayoutId');
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
        Schema::dropIfExists('issued_certificates');
    }
};
