<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSensorSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sensor_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('parameter');
            $table->string('description');
            $table->integer('height')->default(0);
            $table->integer('min_value');
            $table->integer('max_value');
            $table->string('unit');
            $table->string('value_formatter');
            $table->text('value_description');
            $table->text('secondary_unit')->nullable();
            $table->string('chart_type');
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
        Schema::dropIfExists('sensor_settings');
    }
}
