<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AeropuertosMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aeropuertos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('aeropuerto');
            $table->string('ciudad');
            $table->string('pais');
            $table->string('iata');
            $table->string('icao');
            $table->double('latitud');
            $table->double('longitud');
            $table->smallInteger('elevacion');
            $table->tinyInteger('utc');
            $table->char('dst', 1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('aeropuertos');
    }
}