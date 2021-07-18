<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParkingServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parking_services', function (Blueprint $table) {
            $table->bigIncrements('ps_id');
            $table->bigInteger('service_id');
            $table->bigInteger('user_id');
            $table->bigInteger('parking_id');
            $table->string('dated');
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
        Schema::dropIfExists('parking_services');
    }
}
