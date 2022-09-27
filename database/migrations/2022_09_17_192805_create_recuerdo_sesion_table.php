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
        Schema::create('recuerdo_sesion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recuerdo_id');
            $table->unsignedBigInteger('sesion_id');
            $table->timestamps();

            $table->foreign("recuerdo_id")->references("id")->on("recuerdos");
            $table->foreign("sesion_id")->references("id")->on("sesions");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recuerdo_sesion');
    }
};