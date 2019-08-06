<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePromoDays extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_days', function (Blueprint $table) {
            $table->bigIncrements('pd_id');
            $table->integer('promo_id');
            $table->string('monday',1)->default('N')->nullable();
            $table->string('tuesday',1)->default('N')->nullable();
            $table->string('wednesday',1)->default('N')->nullable();
            $table->string('thursday',1)->default('N')->nullable();
            $table->string('friday',1)->default('N')->nullable();
            $table->string('saturday',1)->default('N')->nullable();
            $table->string('sunday',1)->default('N')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promo_days');
    }
}
