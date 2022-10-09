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
        Schema::create('certificate_layouts', function (Blueprint $table) {
            $table->id();
            $table->string('logo1')->nullable();
            $table->string('logo2')->nullable();
            $table->string('cert_type');
            $table->string('cert_header');
            $table->string('cert_title');
            $table->string('cert_purpose')->nullable();
            $table->string('paragraph1');
            $table->string('paragraph2');
            $table->string('paragraph3')->nullable();
            $table->string('paragraph4')->nullable();
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
        Schema::dropIfExists('certificate_layouts');
    }
};
